<?php

namespace App\Services;

use App\Exceptions\InvalidValueException;
use App\ValueObjects\Amount;
use Exception;

class CurrencyExchangeService
{
    public function __construct(readonly private array $rate)
    {

    }

    /**
     * @param string $source
     * @param string $target
     * @param string $amount
     * @return string
     * @throws Exception
     */
    public function convert(string $source, string $target, string $amount): string
    {
        $amount = new Amount(amount: $amount);
        $amount = $amount->toFloat();

        if (is_null($amount)) {
            throw new InvalidValueException("amount not support");
        }
        $rate = $this->getRate(source: $source, target: $target);

        return number_format($rate * round($amount, 2), 2);
    }

    /**
     * @param string $source
     * @param string $target
     * @return float
     * @throws Exception
     */
    private function getRate(string $source, string $target): float
    {
        $source = strtoupper($source);
        $target = strtoupper($target);

        if (!array_key_exists($source, $this->rate)) {
            throw new InvalidValueException("currency not support");
        }

        if (!array_key_exists($target, $this->rate[$source])) {
            throw new InvalidValueException("currency not support");
        }

        return $this->rate[$source][$target];
    }
}
