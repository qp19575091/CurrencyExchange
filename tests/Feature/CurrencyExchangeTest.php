<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CurrencyExchangeTest extends TestCase
{
    /**
     * @dataProvider currencyExchangeShouldReturnExchangedValueProvider
     */
    public function test_example(string $source, string $target, string $amount, string $expected): void
    {
        $response = $this->get("/api/currencyExchange?source=$source&target=$target&amount=$amount");
        $response->assertJson(['msg' => "success", "amount" => $expected]);
    }

    public static function currencyExchangeShouldReturnExchangedValueProvider(): array
    {
        return [
            "amount 1,525 exchange from 'usd' To 'jpy' Should return 170,496.53" => ["USD", "JPY", "1,525", "170,496.53"],
            "amount 1,525 exchange from 'usd' To 'twd' Should return 46,427.10" => ["USD", "TWD", "1,525", "46,427.10"],
            "amount 1,525 exchange from 'usd' To 'usd' Should return 1,525.00" => ["USD", "USD", "1,525", "1,525.00"],
            "amount 1,525 exchange from 'jpy' To 'jpy' Should return 1,525.00" => ["JPY", "JPY", "1,525", "1,525.00"],
            "amount 1,525 exchange from 'jpy' To 'twd' Should return 411.08" => ["JPY", "TWD", "1,525", "411.08"],
            "amount 1,525 exchange from 'jpy' To 'usd' Should return 13.50" => ["JPY", "USD", "1,525", "13.50"],
            "amount 1,525 exchange from 'twd' To 'jpy' Should return 5,595.23" => ["TWD", "JPY", "1,525", "5,595.23"],
            "amount 1,525 exchange from 'twd' To 'usd' Should return 50.04" => ["TWD", "USD", "1,525", "50.04"],
            "amount 1,525 exchange from 'twd' To 'twd' Should return 1,525.00" => ["TWD", "TWD", "1,525", "1,525.00"],
        ];
    }
}
