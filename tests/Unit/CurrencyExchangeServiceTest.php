<?php

namespace Tests\Unit;

use App\Exceptions\InvalidValueException;
use App\Services\CurrencyExchangeService;
use Tests\TestCase;

class CurrencyExchangeServiceTest extends TestCase
{
    private array $rate = [
        "TWD" => [
            "TWD" => 1,
            "JPY" => 3.669,
            "USD" => 0.03281
        ],
        "JPY" => [
            "TWD" => 0.26956,
            "JPY" => 1,
            "USD" => 0.00885
        ],
        "USD" => [
            "TWD" => 30.444,
            "JPY" => 111.801,
            "USD" => 1
        ]
    ];

    /**
     * 若輸入的 source 或 target 系統並不提供時的案例
     * php artisan test --filter CurrencyExchangeServiceTest::testInvalidCurrencyTypeShouldThrowException
     * @dataProvider invalidCurrencyTypeShouldThrowExceptionProvider
     * @return void
     */
    public function testInvalidCurrencyTypeShouldThrowException($source, $target, $amount)
    {
        $this->expectException(InvalidValueException::class);
        $currencyExchange = new CurrencyExchangeService($this->rate);
        $currencyExchange->convert($source, $target, $amount);
    }

    public static function invalidCurrencyTypeShouldThrowExceptionProvider(): array
    {
        return [
            "source not support" => ["RMB", "USD", "1234"],
            "target not support" => ["TWD", "RMB", "1234"],
        ];
    }

    /**
     * 若輸入的金額為非數字或無法辨認時的案例
     * php artisan test --filter CurrencyExchangeServiceTest::testInvalidAmountShouldThrowException
     * @dataProvider invalidAmountShouldThrowExceptionProvider
     * @return void
     */
    public function testInvalidAmountShouldThrowException(string $source, string $target, string $amount)
    {
        $this->expectException(InvalidValueException::class);
        $currencyExchange = new CurrencyExchangeService($this->rate);
        $currencyExchange->convert($source, $target, $amount);
    }

    public static function invalidAmountShouldThrowExceptionProvider(): array
    {
        return [
            "amount has alphabet" => ["USD", "USD", "1,5a25"],
            "amount has Special characters" => ["USD", "USD", "1,52@5"],
            "amount is not currency format" => ["USD", "USD", "1.52,5"],
        ];
    }

    /**
     * 輸入的數字需四捨五入到小數點第二位，並請提供覆蓋有小數與沒有 小數的多種案例
     * php artisan test --filter CurrencyExchangeServiceTest::testAmountWithFloatShouldBeConverted
     * @dataProvider amountWithFloatShouldBeConvertedProvider
     * @return void
     */
    public function testAmountWithFloatShouldBeConverted(string $source, string $target, string $amount, string $expect)
    {
        $currencyExchange = new CurrencyExchangeService($this->rate);
        $result = $currencyExchange->convert($source, $target, $amount);
        $this->assertEquals($expect, $result);
    }

    public static function amountWithFloatShouldBeConvertedProvider(): array
    {
        return [
            "amount 1,525.99 exchange from 'usd' To 'jpy' Should return 170,607.21" => ["USD", "JPY", "1,525.99", "170,607.21"],
            "amount 1,525.32 exchange from 'usd' To 'jpy' Should return 170,532.30" => ["USD", "JPY", "1,525.32", "170,532.30"],
            "amount 1,525 exchange from 'usd' To 'jpy' Should return 170,532.30" => ["USD", "JPY", "1,525", "170,496.53"],
        ];
    }
}

