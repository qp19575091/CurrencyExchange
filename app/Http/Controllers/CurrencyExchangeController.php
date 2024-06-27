<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CurrencyExchangeController extends Controller
{
    public function exchangeCurrency(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(['msg' => "success", "amount"=>"170,496.53"]);
    }
}
