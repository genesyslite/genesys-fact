<?php

use Illuminate\Support\Facades\Route;

Route::post('login', [\GenesysLite\GenesysFact\Http\Controllers\Api\MobileController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {
    //MOBILE
    /*
    Route::get('document/series', [\GenesysLite\GenesysFact\Http\Controllers\Api\MobileController::class, 'getSeries']);
    Route::get('document/tables', [\GenesysLite\GenesysFact\Http\Controllers\Api\MobileController::class, 'tables']);
    Route::get('document/customers', [\GenesysLite\GenesysFact\Http\Controllers\Api\MobileController::class, 'customers']);
    Route::post('document/email', [\GenesysLite\GenesysFact\Http\Controllers\Api\MobileController::class, 'document_email']);
    Route::post('sale-note', [\GenesysLite\GenesysFact\Http\Controllers\Api\SaleNoteController::class, 'store']);
    Route::get('sale-note/series', [\GenesysLite\GenesysFact\Http\Controllers\Api\SaleNoteController::class, 'series']);
    Route::get('sale-note/lists', [\GenesysLite\GenesysFact\Http\Controllers\Api\SaleNoteController::class, 'lists']);
    Route::post('item', [\GenesysLite\GenesysFact\Http\Controllers\Api\MobileController::class, 'item']);
    Route::post('person', [\GenesysLite\GenesysFact\Http\Controllers\Api\MobileController::class, 'person']);
    Route::get('document/search-items', [\GenesysLite\GenesysFact\Http\Controllers\Api\MobileController::class, 'searchItems']);
    Route::get('document/search-customers', [\GenesysLite\GenesysFact\Http\Controllers\Api\MobileController::class, 'searchCustomers']);
    Route::post('sale-note/email', [\GenesysLite\GenesysFact\Http\Controllers\Api\SaleNoteController::class, 'email']);

    Route::get('report', [\GenesysLite\GenesysFact\Http\Controllers\Api\MobileController::class, 'report']);
*/
    Route::post('api/documents', [\GenesysLite\GenesysFact\Http\Controllers\Api\DocumentController::class, 'store']);
    /*
    Route::get('documents/lists', [\GenesysLite\GenesysFact\Http\Controllers\Api\DocumentController::class, 'lists']);
    Route::get('documents/lists/{startDate}/{endDate}', [\GenesysLite\GenesysFact\Http\Controllers\Api\DocumentController::class, 'lists']);
    Route::post('documents/updatedocumentstatus', [\GenesysLite\GenesysFact\Http\Controllers\Api\DocumentController::class, 'updatestatus']);
    Route::post('summaries', [\GenesysLite\GenesysFact\Http\Controllers\Api\SummaryController::class, 'store']);
    Route::post('voided', [\GenesysLite\GenesysFact\Http\Controllers\Api\VoidedController::class, 'store']);
    Route::post('retentions', [\GenesysLite\GenesysFact\Http\Controllers\Api\RetentionController::class, 'store']);
    Route::post('dispatches', [\GenesysLite\GenesysFact\Http\Controllers\Api\DispatchController::class, 'store']);
    Route::post('documents/send', [\GenesysLite\GenesysFact\Http\Controllers\Api\DocumentController::class, 'send']);
    Route::post('summaries/status', [\GenesysLite\GenesysFact\Http\Controllers\Api\SummaryController::class, 'status']);
    Route::post('voided/status', [\GenesysLite\GenesysFact\Http\Controllers\Api\VoidedController::class, 'status']);
    Route::get('services/ruc/{number}', [\GenesysLite\GenesysFact\Http\Controllers\Api\ServiceController::class, 'ruc']);
    Route::get('services/dni/{number}', [\GenesysLite\GenesysFact\Http\Controllers\Api\ServiceController::class, 'dni']);
    Route::post('services/consult_cdr_status', [\GenesysLite\GenesysFact\Http\Controllers\Api\ServiceController::class, 'consultCdrStatus']);
    Route::post('perceptions', [\GenesysLite\GenesysFact\Http\Controllers\Api\PerceptionController::class, 'store']);

    Route::post('documents_server', [\GenesysLite\GenesysFact\Http\Controllers\Api\DocumentController::class, 'storeServer']);
    Route::get('document_check_server/{external_id}', [\GenesysLite\GenesysFact\Http\Controllers\Api\DocumentController::class, 'documentCheckServer']);
   */
});
/*
Route::get('documents/search/customers', [\GenesysLite\GenesysFact\Http\Controllers\Api\DocumentController::class, 'searchCustomers']);

Route::post('services/validate_cpe', [\GenesysLite\GenesysFact\Http\Controllers\Api\ServiceController::class, 'validateCpe']);
Route::post('services/consult_status', [\GenesysLite\GenesysFact\Http\Controllers\Api\ServiceController::class, 'consultStatus']);
Route::post('documents/status', [\GenesysLite\GenesysFact\Http\Controllers\Api\ServiceController::class, 'documentStatus']);

Route::get('sendserver/{document_id}/{query?}', [\GenesysLite\GenesysFact\Http\Controllers\Api\DocumentController::class, 'sendServer']);
Route::post('configurations/generateDispatch', [\GenesysLite\GenesysFact\Models\ConfigurationController::class, 'generateDispatch']);
*/

Route::get('downloads/{model}/{type}/{external_id}/{format?}', [\GenesysLite\GenesysFact\Http\Controllers\DownloadController::class, 'downloadExternal'])->name('download.external_id');