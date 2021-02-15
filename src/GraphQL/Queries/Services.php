<?php

namespace GenesysLite\GenesysFact\GraphQL\Queries;

use GenesysLite\GenesysFact\Helpers\Storage\StorageDocument;
use GenesysLite\GenesysFact\Services\Extras\ExchangeRate;

class Services
{
    protected $wsClient;
    protected $document;
    use StorageDocument;
    const ACCEPTED = '05';

    public function exchangeRate($_, array $args)
    {
        $date = $args['date'];
        Log::info($date);
        $sale = 1;
        if($date <= now()->format('Y-m-d')) {
            $ex_rate = \GenesysLite\GenesysFact\Models\ExchangeRate::where('date', $date)->first();
            if ($ex_rate) {
                $sale = $ex_rate->sale;
            } else {
                $exchange_rate = new ExchangeRate();
                $res = $exchange_rate->searchDate($date);
                if ($res) {
                    $ex_rate = \GenesysLite\GenesysFact\Models\ExchangeRate::create([
                        'date' => $date,
                        'date_original' => $res['date_data'],
                        'purchase' => $res['data']['purchase'],
                        'purchase_original' => $res['data']['purchase'],
                        'sale' => $res['data']['sale'],
                        'sale_original' => $res['data']['sale']
                    ]);
                    $sale = $ex_rate->sale;
                }else{
                    $last_ex_rate = \GenesysLite\GenesysFact\Models\ExchangeRate::orderBy('date', 'desc')->first();
                    if ($last_ex_rate) {
                        $sale = $last_ex_rate->sale;
                    }
                    else {
                        $sale = 0;
                    }
                }
            }
        }
        return [
            'date' => $date,
            'sale' => $sale
        ];
    }
}