<?php

namespace  GenesysLite\GenesysFact\Observers;

use GenesysLite\GenesysBusiness\Models\Configuration;
use GenesysLite\GenesysFact\Models\Document;
use  GenesysLite\GenesysFact\Requests\Inputs\Functions;

class DocumentObserver
{
    public function creating(Document $document)
    {
        $company = Configuration::BusinessData();
        $number = Functions::newNumber($document->soap_type_id,
                                       $document->document_type_id,
                                       $document->series,
                                       $document->number, Document::class);
        $document->number = $number;

        $document->filename = Functions::filename($company, $document->document_type_id, $document->series, $number);

    }

    public function updated(Document $document)
    {
        //
    }

    public function deleted(Document $document)
    {
        //
    }

    public function restored(Document $document)
    {
        //
    }

    public function forceDeleted(Document $document)
    {
        //
    }
}
