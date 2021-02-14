<?php

namespace GenesysLite\GenesysFact\Models;

use GenesysLite\GenesysCatalog\Models\CardBrand;
use GenesysLite\GenesysFact\Models\System\PaymentMethodType;
use Illuminate\Database\Eloquent\Model;
use GenesysLite\GenesysFact\Contracts\DocumentPayment as DocumentPaymentContract;

class DocumentPayment extends Model implements DocumentPaymentContract
{
    protected $with = ['payment_method_type', 'card_brand'];
    public $timestamps = false;

    protected $fillable = [
        'document_id',
        'date_of_payment',
        'payment_method_type_id',
        'has_card',
        'card_brand_id',
        'reference',
        'change',
        'payment',
    ];

    protected $casts = [
        'date_of_payment' => 'date',
    ];

    public function payment_method_type()
    {
        return $this->belongsTo(PaymentMethodType::class);
    }

    public function card_brand()
    {
        return $this->belongsTo(CardBrand::class);
    }

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }


    public function associated_record_payment()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }


}
