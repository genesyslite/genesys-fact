<?php

namespace GenesysLite\GenesysFact\Requests\Inputs\Common;

use GenesysLite\GenesysBusiness\Models\Configuration;
use GenesysLite\GenesysFact\Helpers\Number\NumberLetter;

class LegendInput
{
    public static function set($inputs)
    {
        $legends = [];
        if(array_key_exists('legends', $inputs)) {
            if($inputs['legends']) {
                foreach ($inputs['legends'] as $row)
                {
                    $code = $row['code'];
                    $value = $row['value'];

                    $legends[] = [
                        'code' => $code,
                        'value' => $value
                    ];
                }
            }
        }
        
        if(Configuration::OperationAmazonia() && in_array($inputs['document_type_id'], ['01', '03'])){

            $legends[] = [
                'code' => 2002,
                'value' => 'SERVICIOS PRESTADOS EN LA AMAZONÍA  REGIÓN SELVA PARA SER CONSUMIDOS EN LA MISMA'
            ];

            $legends[] = [
                'code' => 2001,
                'value' => 'BIENES TRANSFERIDOS EN LA AMAZONÍA REGIÓN SELVA PARA SER CONSUMIDOS EN LA MISMA'
            ];

        }

        if(array_key_exists('total', $inputs)) {
            $legends[] = [
                'code' => 1000,
                'value' => NumberLetter::convertToLetter($inputs['total'])
            ];
        }

        return $legends;
    }
}