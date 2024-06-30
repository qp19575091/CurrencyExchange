<?php

namespace App\Rules;

use App\ValueObjects\Amount;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AmountRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $amount = new Amount(amount: $value);

        if (is_null($amount->toFloat()))
        {
            $fail("value not allow");
        }
    }
}
