<?php

namespace App\ValueObjects;

class Amount
{

    public function __construct(private string $amount)
    {
        $pattern = '/^\d{1,3}(,\d{3})*(\.\d{2})?$/';

        if (!is_numeric($amount)){
            if (!preg_match($pattern, $amount)) {
                throw new \Exception("amount not support");
            }
        }
    }

    public function toFloat(): float
    {
        if (is_numeric($this->amount)) {
            return (float) $this->amount;
        } else {
            return (float) str_replace(",", '', $this->amount);
        }
    }
}
