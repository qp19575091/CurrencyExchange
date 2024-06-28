<?php

namespace App\Http\Requests;

use App\Enums\Currency;
use App\Rules\CurrencyRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExchangeCurrencyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "source" => ["required", Rule::enum(Currency::class)],
            "target" => ["required", Rule::enum(Currency::class)],
            "amount" => ["required", new CurrencyRule()],
        ];
    }
}
