<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CurrencyExchangeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/api/currencyExchange?source=USD&target=JPY&amount=1,525');


        $response->assertJson(['msg' => "success", "amount"=>"170,496.53"]);
    }
}
