<?php

namespace Tests\Unit;

use App\ValueObjects\Amount;
use PHPUnit\Framework\TestCase;

class AmountTest extends TestCase
{
    /**
     * @dataProvider invalidAmountCanNotBeFormatToFloatProvider
     *  php artisan test --filter AmountTest::testInvalidAmountCanNotBeFormatToFloat
     */
    public function testInvalidAmountCanNotBeFormatToFloat(string $inputAmount): void
    {
        $amount = new Amount($inputAmount);
        $this->assertEquals(null, $amount->toFloat());
    }

    public static function invalidAmountCanNotBeFormatToFloatProvider(): array
    {
        return [
            "Integer with special can not be format to float" => ["123@4"],
            "Integer with wrong thousandth place can not be format to float" => ["12,34"],
        ];
    }

    /**
     * @dataProvider validAmountCanBeFormatToFloatProvider
     * php artisan test --filter AmountTest::testValidAmountCanBeFormatToFloat
     */
    public function testValidAmountCanBeFormatToFloat(string $inputAmount, $expectAmount): void
    {
        $amount = new Amount($inputAmount);
        $this->assertEquals($expectAmount, $amount->toFloat());
    }

    public static function validAmountCanBeFormatToFloatProvider(): array
    {
        return [
            "Integer can be format to float" => ["1234", 1234],
            "Integer with thousandth place can be format to float" => ["1,234", 1234],
            "Two decimal places can be format to float" => ["1234.23", 1234.23],
            "Two decimal places with thousandth place can be format to float" => ["1,234.23", 1234.23],
            "The two decimal places are all 0 can be format to float" => ["1234.00", 1234],
        ];
    }
}
