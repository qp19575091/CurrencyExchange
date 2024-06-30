<?php

namespace App\ValueObjects;

class Amount
{
    public function __construct(private readonly string $amount)
    {
    }

    /**
     * @return float|null
     */
    public function toFloat(): ?float
    {
        if (!$this->canBeFormat()){
            return null;
        }

        if (is_numeric($this->amount)) {
            return (float) $this->amount;
        } else {
            return (float) str_replace(",", '', $this->amount);
        }
    }

    /**
     * @return bool
     */
    private function canBeFormat(): bool
    {
        $pattern = '/^\d{1,3}(,\d{3})*(\.\d{2})?$/';

        if (!is_numeric($this->amount)) {
            if (!preg_match($pattern, $this->amount)) {
                return false;
            }
        }

        return true;
    }

}
