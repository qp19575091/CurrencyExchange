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

    public function exchangeCurrency(ExchangeCurrencyRequest $request): \Illuminate\Http\JsonResponse
    {
        $result = $this->currencyExchangeService->currencyExchange($request->source, $request->target, $request->amount);

        return response()->json(['msg' => "success", "amount"=>$result]);
    }
}
