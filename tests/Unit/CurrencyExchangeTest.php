<?php

namespace Tests\Unit;

use App\Services\CurrencyExchangeService;
use PHPUnit\Framework\TestCase;

class CurrencyExchangeTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $currencyExchangeService = new CurrencyExchangeService();
        $this->assertEquals(
            ['msg' => "success", "amount" => "170,496.53"],
            $currencyExchangeService->currencyExchange("USD", "JPY", "1,525")
        );
    }
}
