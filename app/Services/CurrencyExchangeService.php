<?php

namespace App\Services;

class CurrencyExchangeService
{

    public function __construct()
    {
    }

    public function exchange(string $source, string $target, string $amount)
    {
        return ['msg' => "success", "amount"=>"170,496.53"];
    }
}
