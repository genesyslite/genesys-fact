<?php

namespace GenesysLite\GenesysFact\Requests\Api\Validation;

class VoidedValidation
{
    public static function validation($inputs)
    {
        $inputs['documents'] = Functions::voidedDocuments($inputs, 'voided');
        return $inputs;
    }
}