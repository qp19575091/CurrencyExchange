<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CurrencyRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $pattern = '/^\d{1,3}(,\d{3})*(\.\d{2})?$/';

        if (!is_numeric($value)){
           if (!preg_match($pattern, $value)) {
               $fail("value not allow");
           }
        }
    }
}
