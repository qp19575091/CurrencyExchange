<?php

namespace App\Services;

class CurrencyExchangeService
{
    public function __construct(readonly private array $rate)
    {
    }

    public function currencyExchange(string $source, string $target, string $amount)
    {
        if (is_numeric($amount)) {
            $result = $this->rate[$source][$target] * $amount;
        } else {
            $amount = (int) str_replace(",", '', $amount);
            $result = $this->rate[$source][$target] * $amount;
        }

        return number_format($result, 2);
    }
}
