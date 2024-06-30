<?php

namespace Tests\Unit;

use App\Services\CurrencyExchangeService;
use Tests\TestCase;

class CurrencyExchangeServiceTest extends TestCase
{
    /**
     * php artisan test --filter CurrencyExchangeServiceTest::testInvalidCurrencyTypeShouldThrowException
     * @dataProvider invalidCurrencyTypeShouldThrowExceptionProvider
     * @return void
     */
    public function testInvalidCurrencyTypeShouldThrowException($source, $target, $amount)
    {
        $this->expectException(\Exception::class);
        $currencyExchange = new CurrencyExchangeService(config('currency.rate'));
        $currencyExchange->convert($source,$target,$amount);
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
        $currencyExchange = new CurrencyExchangeService(config('currency.rate'));
        $currencyExchange->convert($source,$target,$amount);
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
     * php artisan test --filter CurrencyExchangeServiceTest::testAmountWithFloatShouldBeConverted
     * @dataProvider amountWithFloatShouldBeConvertedProvider
     * @return void
     */
    public function testAmountWithFloatShouldBeConverted(string $source, string $target, string $amount, string $expect)
    {
        $currencyExchange = new CurrencyExchangeService(config('currency.rate'));
        $result = $currencyExchange->convert($source,$target,$amount);
        $this->assertEquals($expect, $result);
    }

    public static function amountWithFloatShouldBeConvertedProvider(): array
    {
        return [
            "amount 1,525.99 exchange from 'usd' To 'jpy' Should return 170,607.21" => ["USD", "JPY", "1,525.99", "170,607.21"],
            "amount 1,525.32 exchange from 'usd' To 'jpy' Should return 170,532.30" => ["USD", "JPY", "1,525.32", "170,532.30"],
        ];
    }
}

