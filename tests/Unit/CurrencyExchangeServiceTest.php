<?php

namespace Tests\Unit;

use App\Services\CurrencyExchangeService;
use PHPUnit\Framework\TestCase;

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
     * php artisan test --filter CurrencyExchangeServiceTest::testInvalidCurrencyTypeShouldThrowException
     * @dataProvider invalidCurrencyTypeShouldThrowExceptionProvider
     * @return void
     */
    public function testInvalidCurrencyTypeShouldThrowException($source, $target, $amount)
    {
        $this->expectException(\Exception::class);
        $currencyExchange = new CurrencyExchangeService($this->rate);
        $currencyExchange->currencyExchange($source,$target,$amount);
    }

    public static function invalidCurrencyTypeShouldThrowExceptionProvider(): array
    {
        return [
            "source not support" => ["RMB", "USD", "1234"],
            "target not support" => ["TWD", "RMB", "1234"],
        ];
    }

    /**
     * php artisan test --filter CurrencyExchangeServiceTest::testInvalidAmountShouldThrowException
     * @dataProvider invalidAmountShouldThrowExceptionProvider
     * @return void
     */
    public function testInvalidAmountShouldThrowException($source, $target, $amount)
    {
        $this->expectException(\Exception::class);
        $currencyExchange = new CurrencyExchangeService($this->rate);
        $currencyExchange->currencyExchange($source,$target,$amount);
    }

    public static function invalidAmountShouldThrowExceptionProvider(): array
    {
        return [
            "amount has alphabet" => ["USD", "USD", "1,5a25"],
            "amount has Special characters" => ["USD", "USD", "1,52@5"],
            "amount is not currency format" => ["USD", "USD", "1.52,5"],
        ];
    }
}
