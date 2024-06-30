<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class CurrencyExchangeTest extends TestCase
{
    /**
     * @dataProvider currencyExchangeShouldReturnExchangedValueProvider
     */
    public function testCurrencyExchangeShouldReturnExchangedValue(string $source, string $target, string $amount, string $expected): void
    {
        $response = $this->getJson("/api/currencyExchange?source=$source&target=$target&amount=$amount");
        $response->assertJson(['msg' => "success", "amount" => $expected]);
    }

    /**
     * @return array
     */
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

    /**
     * source、target 為字串，amount 輸入時無論有無千分位 皆可接受
     * @dataProvider invalidRequestParamsShouldThrowExceptionProvider
     * php artisan test  --filter CurrencyExchangeTest::testInvalidRequestParamsShouldThrowException
     */
    public function testInvalidRequestParamsShouldThrowException($source, $target, $amount)
    {
        $response = $this->getJson("/api/currencyExchange?source=$source&target=$target&amount=$amount");
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public static function invalidRequestParamsShouldThrowExceptionProvider(): array
    {
        return [
            "source is integer" => [123, "JPY", "1,525"],
            "target is integer" => ["USD", 123, "1,525"],
            "amount has alphabet" => ["USD", "USD", "1,525a"],
            "amount has Special characters" => ["JPY", "JPY", "1,525@"],
            "amount is not currency format" => ["JPY", "TWD", "1,52,5"],
        ];
    }

    /**
     * 需驗證使用者輸入的值。source、target 為字串,amount 輸入時無論有無千分位
     * 皆可接受。例如「1,525」或「1525」皆可。
     *
     * @dataProvider validRequestParamsShouldThrowExceptionProvider
     * php artisan test  --filter CurrencyExchangeTest::testValidRequestParamsShouldThrowException
     */
    public function testValidRequestParamsShouldThrowException($source, $target, $amount)
    {
        $response = $this->getJson("/api/currencyExchange?source=$source&target=$target&amount=$amount");
        $response->assertStatus(Response::HTTP_OK);
    }

    public static function validRequestParamsShouldThrowExceptionProvider(): array
    {
        return [
            "amount with thousand is valid " => ["JPY", "JPY", "1,525"],
            "amount without thousand is valid " => ["JPY", "JPY", "1525"],
        ];
    }
}
