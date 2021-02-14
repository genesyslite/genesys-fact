<?php
namespace GenesysLite\GenesysFact\Http\Controllers;

use GenesysLite\GenesysBusiness\Models\Configuration;
use GenesysLite\GenesysBusiness\Models\Establishment;
use GenesysLite\GenesysCatalog\Models\ChargeDiscountType;
use GenesysLite\GenesysCatalog\Models\CurrencyType;
use GenesysLite\GenesysCatalog\Models\DocumentType;
use GenesysLite\GenesysCatalog\Models\NoteCreditType;
use GenesysLite\GenesysCatalog\Models\NoteDebitType;
use GenesysLite\GenesysCatalog\Models\OperationType;
use GenesysLite\GenesysCrm\Models\Person;
use GenesysLite\GenesysFact\Api\Request\DocumentRequest;
use GenesysLite\GenesysFact\Api\Resource\DocumentCollection;
use GenesysLite\GenesysFact\Facturalo;
use GenesysLite\GenesysFact\Helpers\Storage\StorageDocument;
use GenesysLite\GenesysFact\Models\Document;
use GenesysLite\GenesysFact\Models\Series;
use Illuminate\Support\Facades\Request;

class DocumentController extends Controller
{
    use StorageDocument, OfflineTrait, FinanceTrait;
    private $max_count_payment = 0;

    public function __construct()
    {

        $this->middleware('input.request:document,web', ['only' => ['store']]);
    }
    public function store(DocumentRequest $request)
    {
        $invoice = new Facturalo();
        $invoice->save($request->all());
        $invoice->createXmlUnsigned();
        $invoice->signXmlUnsigned();
        $invoice->updateHash();
        $invoice->updateQr();
        $invoice->createPdf();
        $invoice->senderXmlSignedBill();

        $document = $invoice->getDocument();
        $response = $invoice->getResponse();

        return [
            'success' => true,
            'data' => [
                'id' => $document->id,
                'response' =>$response

            ],
        ];
    }

    public function reStore($document_id)
    {
        $fact = DB::connection('tenant')->transaction(function () use ($document_id) {
            $document = Document::find($document_id);

            $type = 'invoice';
            if($document->document_type_id === '07') {
                $type = 'credit';
            }
            if($document->document_type_id === '08') {
                $type = 'debit';
            }

            $facturalo = new Facturalo();
            $facturalo->setDocument($document);
            $facturalo->setType($type);
            $facturalo->createXmlUnsigned();
            $facturalo->signXmlUnsigned();
            $facturalo->updateHash();
            $facturalo->updateQr();
            $facturalo->updateSoap('02', $type);
            $facturalo->updateState('01');
            $facturalo->createPdf($document, $type, 'ticket');
//            $facturalo->senderXmlSignedBill();
        });

//        $document = $fact->getDocument();
//        $response = $fact->getResponse();

        return [
            'success' => true,
            'message' => 'El documento se volvio a generar.',
        ];
    }

    public function email(DocumentEmailRequest $request)
    {
        $company = Company::active();
        $document = Document::find($request->input('id'));
        $customer_email = $request->input('customer_email');

        Mail::to($customer_email)->send(new DocumentEmail($company, $document));

        return [
            'success' => true
        ];
    }

    public function send($document_id) {
        $document = Document::find($document_id);

        $fact = DB::connection('tenant')->transaction(function () use ($document) {
            $facturalo = new Facturalo();
            $facturalo->setDocument($document);
            $facturalo->loadXmlSigned();
            $facturalo->onlySenderXmlSignedBill();
            return $facturalo;
        });

        $response = $fact->getResponse();

        return [
            'success' => true,
            'message' => $response['description'],
        ];
    }

    public function consultCdr($document_id)
    {
        $document = Document::find($document_id);

        $fact = DB::connection('tenant')->transaction(function () use ($document) {
            $facturalo = new Facturalo();
            $facturalo->setDocument($document);
            $facturalo->consultCdr();
        });

        $response = $fact->getResponse();

        return [
            'success' => true,
            'message' => $response['description'],
        ];
    }

    public function sendServer($document_id, $query = false) {
        $document = Document::find($document_id);
        // $bearer = config('tenant.token_server');
        // $api_url = config('tenant.url_server');
        $bearer = $this->getTokenServer();
        $api_url = $this->getUrlServer();
        $client = new Client(['base_uri' => $api_url, 'verify' => false]);

       // $zipFly = new ZipFly();
        if(!$document->data_json) throw new Exception("Campo data_json nulo o inválido - Comprobante: {$document->fullnumber}");

        $data_json = (array) $document->data_json;
        $data_json['numero_documento'] = $document->number;
        $data_json['external_id'] = $document->external_id;
        $data_json['hash'] = $document->hash;
        $data_json['qr'] = $document->qr;
        $data_json['query'] = $query;
        $data_json['file_xml_signed'] = base64_encode($this->getStorage($document->filename, 'signed'));
        $data_json['file_pdf'] = base64_encode($this->getStorage($document->filename, 'pdf'));
        // dd($data_json);
        $res = $client->post('/api/documents_server', [
            'http_errors' => false,
            'headers' => [
                'Authorization' => 'Bearer '.$bearer,
                'Accept' => 'application/json',
            ],
            'form_params' => $data_json
        ]);

        $response = json_decode($res->getBody()->getContents(), true);

        if ($response['success']) {
            $document->send_server = true;
            $document->save();
        }

        return $response;
    }

    public function checkServer($document_id) {
        $document = Document::find($document_id);
        $bearer = $this->getTokenServer();
        $api_url = $this->getUrlServer();

        $client = new Client(['base_uri' => $api_url, 'verify' => false]);

        $res = $client->get('/api/document_check_server/'.$document->external_id, [
            'headers' => [
                'Authorization' => 'Bearer '.$bearer,
                'Accept' => 'application/json',
            ],
        ]);

        $response = json_decode($res->getBody()->getContents(), true);

        if ($response['success']) {
            $state_type_id = $response['state_type_id'];
            $document->state_type_id = $state_type_id;
            $document->save();

            if ($state_type_id === '05') {
                $this->uploadStorage($document->filename, base64_decode($response['file_cdr']), 'cdr');
            }
        }

        return $response;
    }

    public function searchCustomerById($id)
    {

        $customers = Person::with('addresses')->whereType('customers')
                    ->where('id',$id)
                    ->get()->transform(function($row) {
                        return [
                            'id' => $row->id,
                            'description' => $row->number.' - '.$row->name,
                            'name' => $row->name,
                            'number' => $row->number,
                            'identity_document_type_id' => $row->identity_document_type_id,
                            'identity_document_type_code' => $row->identity_document_type->code,
                            'addresses' => $row->addresses,
                            'address' =>  $row->address
                        ];
                    });

        return compact('customers');
    }

    public function getIdentityDocumentTypeId($document_type_id, $operation_type_id){

        // if($operation_type_id === '0101' || $operation_type_id === '1001') {

        if(in_array($operation_type_id, ['0101', '1001', '1004'])) {

            if($document_type_id == '01'){
                $identity_document_type_id = [6];
            }else{
                if(config('tenant.document_type_03_filter')){
                    $identity_document_type_id = [1];
                }else{
                    $identity_document_type_id = [1,4,6,7,0];
                }
            }
        } else {
            $identity_document_type_id = [1,4,6,7,0];
        }

        return $identity_document_type_id;
    }

    public function changeToRegisteredStatus($document_id)
    {
        $document = Document::find($document_id);
        if($document->state_type_id === '01') {
            $document->state_type_id = '05';
            $document->save();

            return [
                'success' => true,
                'message' => 'El estado del documento fue actualizado.',
            ];
        }
    }

    public function import(Request $request)
    {
        if ($request->hasFile('file')) {
            try {
                $import = new DocumentsImport();
                $import->import($request->file('file'), null, Excel::XLSX);
                $data = $import->getData();
                return [
                    'success' => true,
                    'message' =>  __('app.actions.upload.success'),
                    'data' => $data
                ];
            } catch (Exception $e) {
                return [
                    'success' => false,
                    'message' =>  $e->getMessage()
                ];
            }
        }
        return [
            'success' => false,
            'message' =>  __('app.actions.upload.error'),
        ];
    }

    public function importTwoFormat(Request $request)
    {
        if ($request->hasFile('file')) {
            try {
                $import = new DocumentsImportTwoFormat();
                $import->import($request->file('file'), null, Excel::XLSX);
                $data = $import->getData();
                return [
                    'success' => true,
                    'message' =>  __('app.actions.upload.success'),
                    'data' => $data
                ];
            } catch (Exception $e) {
                return [
                    'success' => false,
                    'message' =>  $e->getMessage()
                ];
            }
        }
        return [
            'success' => false,
            'message' =>  __('app.actions.upload.error'),
        ];
    }

    public function messageLockedEmission(){

        $configuration = Configuration::first();
        // $quantity_documents = Document::count();
        $quantity_documents = $configuration->quantity_documents;

        if($configuration->limit_documents !== 0 && ($quantity_documents > $configuration->limit_documents))
            return [
                'success' => false,
                'message' => 'Alcanzó el límite permitido para la emisión de comprobantes',
            ];


        return [
            'success' => true,
            'message' => '',
        ];
    }

    public function getRecords($request){


        $d_end = $request->d_end;
        $d_start = $request->d_start;
        $date_of_issue = $request->date_of_issue;
        $document_type_id = $request->document_type_id;
        $state_type_id = $request->state_type_id;
        $number = $request->number;
        $series = $request->series;
        $pending_payment = ($request->pending_payment == "true") ? true:false;
        $customer_id = $request->customer_id;
        $item_id = $request->item_id;
        $category_id = $request->category_id;


        if($d_start && $d_end){

            $records = Document::where('document_type_id', 'like', '%' . $document_type_id . '%')
                            ->where('series', 'like', '%' . $series . '%')
                            ->where('number', 'like', '%' . $number . '%')
                            ->where('state_type_id', 'like', '%' . $state_type_id . '%')
                            ->whereBetween('date_of_issue', [$d_start , $d_end])
                            ->whereTypeUser()
                            ->latest();

        }else{

            $records = Document::where('date_of_issue', 'like', '%' . $date_of_issue . '%')
                            ->where('document_type_id', 'like', '%' . $document_type_id . '%')
                            ->where('state_type_id', 'like', '%' . $state_type_id . '%')
                            ->where('series', 'like', '%' . $series . '%')
                            ->where('number', 'like', '%' . $number . '%')
                            ->whereTypeUser()
                            ->latest();
        }

        if($pending_payment){
            $records = $records->where('total_canceled', false);
        }

        if($customer_id){
            $records = $records->where('customer_id', $customer_id);
        }

        if($item_id){
            $records = $records->whereHas('items', function($query) use($item_id){
                                    $query->where('item_id', $item_id);
                                });
        }

        if($category_id){

            $records = $records->whereHas('items', function($query) use($category_id){
                                    $query->whereHas('relation_item', function($q) use($category_id){
                                        $q->where('category_id', $category_id);
                                    });
                                });
        }

        return $records;
    }

    public function data_table()
    {

        $customers = $this->table('customers');
        $items = $this->getItems();
        $categories = Category::orderBy('name')->get();
        $state_types = StateType::get();
        $document_types = DocumentType::whereIn('id', ['01', '03','07', '08'])->get();
        $series = Series::whereIn('document_type_id', ['01', '03','07', '08'])->get();
        $establishments = Establishment::where('id', auth()->user()->establishment_id)->get();// Establishment::all();

        return compact( 'customers', 'document_types','series','establishments', 'state_types', 'items', 'categories');

    }


    public function getItems(){

        $items = Item::orderBy('description')->take(20)->get()->transform(function($row) {
            return [
                'id' => $row->id,
                'description' => ($row->internal_id) ? "{$row->internal_id} - {$row->description}" :$row->description,
            ];
        });

        return $items;

    }


    public function getDataTableItem(Request $request) {

        $items = Item::where('description','like', "%{$request->input}%")
                        ->orWhere('internal_id','like', "%{$request->input}%")
                        ->orderBy('description')
                        ->get()->transform(function($row) {
                            return [
                                'id' => $row->id,
                                'description' => ($row->internal_id) ? "{$row->internal_id} - {$row->description}" :$row->description,
                            ];
                        });

        return $items;

    }


    private function updateMaxCountPayments($value)
    {
        if($value > $this->max_count_payment)
        {
            $this->max_count_payment = $value;
        }
       // $this->max_count_payment = 20 ;//( $value > $this->max_count_payment) ? $value : $this->$max_count_payment;
    }

    private function transformReportPayment($resource)
    {

        $records = $resource->transform(function($row) {

            $total_paid = collect($row->payments)->sum('payment');
            $total = $row->total;
            $total_difference = round($total - $total_paid, 2);

            $this->updateMaxCountPayments($row->payments->count());

            return (object)[

                'id' => $row->id,
                'ruc' => $row->customer->number,
                // 'date' =>  $row->date_of_issue->format('Y-m-d'),
                // 'date' =>  $row->date_of_issue,
                'date' =>  $row->date_of_issue->format('d/m/Y'),
                'invoice' => $row->number_full,
                'comercial_name' => $row->customer->trade_name,
                'business_name' => $row->customer->name,
                'zone' => $row->customer->department->description,
                'total' => number_format($row->total, 2, ".",""),

                'payments' => $row->payments,

                /*'payment1' =>  ( isset($row->payments[0]) ) ?  number_format($row->payments[0]->payment, 2) : '',
                'payment2' =>  ( isset($row->payments[1]) ) ?  number_format($row->payments[1]->payment, 2) : '',
                'payment3' =>   ( isset($row->payments[2]) ) ?  number_format($row->payments[2]->payment, 2) : '',
                'payment4' =>   ( isset($row->payments[3]) ) ?  number_format($row->payments[3]->payment, 2) : '', */

                'balance' => $total_difference,
                'person_type' => isset($row->person->person_type->description) ? $row->person->person_type->description:'',
                'department' => $row->customer->department->description,
                'district' => $row->customer->district->description,

                /*'reference1' => ( isset($row->payments[0]) ) ?  $row->payments[0]->reference : '',
                'reference2' =>  ( isset($row->payments[1]) ) ?  $row->payments[1]->reference : '',
                'reference3' =>  ( isset($row->payments[2]) ) ?  $row->payments[2]->reference : '',
                'reference4' =>  ( isset($row->payments[3]) ) ?  $row->payments[3]->reference : '', */
            ];
        });

        return $records;
    }

    public function report_payments(Request $request)
    {
        // $month_format = Carbon::parse($month)->format('m');

        if($request->anulled == 'true') {
           $records = Document::whereBetween('date_of_issue', [$request->date_start, $request->date_end])->get();
        } else {
            $records = Document::whereBetween('date_of_issue', [$request->date_start, $request->date_end])->where('state_type_id', '!=', '11')->get();
        }

        $source =  $this->transformReportPayment( $records );

        return (new PaymentExport)
                ->records($source)
                ->payment_count($this->max_count_payment)
                ->download('Reporte_Pagos_'.Carbon::now().'.xlsx');

    }

    public function destroyDocument($document_id)
    {
        try {

            DB::connection('tenant')->transaction(function () use ($document_id) {

                $record = Document::findOrFail($document_id);
                $this->deleteAllPayments($record->payments);
                $record->delete();

            });

            return [
                'success' => true,
                'message' => 'Documento eliminado con éxito'
            ];

        } catch (Exception $e) {

            return ($e->getCode() == '23000') ? ['success' => false,'message' => 'El Documento esta siendo usada por otros registros, no puede eliminar'] : ['success' => false,'message' => 'Error inesperado, no se pudo eliminar el Documento'];

        }


    }

    public function storeCategories(CategoryRequest $request)
    {
        $id = $request->input('id');
        $category = Category::firstOrNew(['id' => $id]);
        $category->fill($request->all());
        $category->save();


        return [
            'success' => true,
            'message' => ($id)?'Categoría editada con éxito':'Categoría registrada con éxito',
            'data' => $category

        ];
    }

    public function storeBrands(BrandRequest $request){
         $id = $request->input('id');
        $brand = Brand::firstOrNew(['id' => $id]);
        $brand->fill($request->all());
        $brand->save();


        return [
            'success' => true,
            'message' => ($id)?'Marca editada con éxito':'Marca registrada con éxito',
            'data' => $brand
        ];
    }

    public function searchExternalId(Request $request)
    {
        return response()->json(Document::where('external_id', $request->external_id)->first());
    }

}
