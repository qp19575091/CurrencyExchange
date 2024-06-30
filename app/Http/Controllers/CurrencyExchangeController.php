<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExchangeCurrencyRequest;
use App\Services\CurrencyExchangeService;
use Illuminate\Http\Request;

class CurrencyExchangeController extends Controller
{
    public function __construct(private CurrencyExchangeService $currencyExchangeService)
    {
    }

    /**
     * @throws \Exception
     */
    public function exchangeCurrency(ExchangeCurrencyRequest $request): \Illuminate\Http\JsonResponse
    {
        $result = $this->currencyExchangeService->convert(
            source: $request->source,
            target: $request->target,
            amount: $request->amount
        );

        return response()->json(['msg' => "success", "amount" => $result]);
    }
}
