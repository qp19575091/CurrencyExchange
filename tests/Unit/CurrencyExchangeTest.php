<?php

namespace Tests\Unit;

use App\Services\CurrencyExchangeService;
use PHPUnit\Framework\TestCase;

class CurrencyExchangeTest extends TestCase
{
    /**
     * @dataProvider currencyExchangeShouldReturnExchangedValueProvider
     */
    public function testCurrencyExchangeShouldReturnExchangedValue($source, $target, $amount, $expected): void
    {
        $currencyExchangeService = new CurrencyExchangeService();
    }
}
