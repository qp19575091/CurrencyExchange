<?php

namespace App\Services;

class CurrencyExchangeService
{

    public function __construct()
    {
    }

    public function currencyExchange(string $source, string $target, string $amount)
    {
        $exchangeMap = [
            "TWD" => [
                "TWD" => 1,
                "JPY" => 3.669,
                "USD" => 0.03281
            ],
            "JPY" => [
                "TWD" => 0.26956,
                "JPY" => 1,
                "USD" => 0.00885
            ],
            "USD" => [
                "TWD" => 30.444,
                "JPY" => 111.801,
                "USD" => 1
            ]
        ];

        if (is_numeric($amount)) {
            $result = $exchangeMap[$source][$target] * $amount;
        } else {
            $amount = (int)str_replace(",", '', $amount);
            $result = $exchangeMap[$source][$target] * $amount;
        }

        return ['msg' => "success", "amount" => number_format($result, 2)];
    }
}
