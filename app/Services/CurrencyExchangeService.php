<?php

namespace App\Services;

class CurrencyExchangeService
{
    public function __construct(readonly private array $rate)
    {

    }

    /**
     * @throws \Exception
     */
    public function currencyExchange(string $source, string $target, string $amount)
    {
        $source = strtoupper($source);
        $target = strtoupper($target);

        $this->validateCurrencySupport($source,$this->rate);
        $this->validateCurrencySupport($target,$this->rate[$source]);


        $this->validateAmountSupport($amount);

        if (is_numeric($amount)) {
            $result = $this->rate[$source][$target] * $amount;
        } else {
            $amount = (int) str_replace(",", '', $amount);
            $result = $this->rate[$source][$target] * $amount;
        }

        return number_format($result, 2);
    }

    /**
     * @param string $source
     * @return void
     * @throws \Exception
     */
    private function validateCurrencySupport(string $source, array $rate): void
    {
        if (!array_key_exists($source, $rate)) {
            throw new \Exception("currency not support");
        }
    }

    /**
     * @param string $amount
     * @return void
     */
    public function validateAmountSupport(string $amount): void
    {
        $pattern = '/^\d{1,3}(,\d{3})*(\.\d{2})?$/';

        if (!is_numeric($amount)){
            if (!preg_match($pattern, $amount)) {
                throw new \Exception("amount not support");
            }
        }
    }
}
