<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExchangeCurrencyRequest;
use App\Services\CurrencyExchangeService;
use Illuminate\Http\Request;

class CurrencyExchangeController extends Controller
{
    public function exchangeCurrency(ExchangeCurrencyRequest $request): \Illuminate\Http\JsonResponse
    {
        $currencyExchangeService = new CurrencyExchangeService();
        $result = $currencyExchangeService->currencyExchange($request->source, $request->target, $request->amount);

        return response()->json(['msg' => "success", "amount"=>$result]);
    }
}
