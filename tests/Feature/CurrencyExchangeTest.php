<?php

namespace Tests\Feature;

use Tests\TestCase;

class CurrencyExchangeTest extends TestCase
{
    /**
     * @dataProvider input_provider
     */
    public function test_exchange_api($fromAmount, $fromCurrency, $toAmount, $toCurrency)
    {
        $this->json('GET', '/api/currency/exchange', [
            'fromCurrency' => $fromCurrency,
            'toCurrency' => $toCurrency,
            'amount' => $fromAmount,
        ])->assertStatus(200)
        ->assertJson(['toAmount'=>$toAmount]);
    }

    /**
     * @dataProvider error_input_provider
     */
    public function test_exchange_api_validate($fromAmount, $fromCurrency, $toAmount, $toCurrency)
    {
        $this->json('GET', '/api/currency/exchange', [
            'fromCurrency' => $fromCurrency,
            'toCurrency' => $toCurrency,
            'amount' => $fromAmount,
        ])->assertStatus(400);
    }

    public function input_provider()
    {
        return [
            [100, 'TWD', '366.90', 'JPY'],
            [100, 'TWD', '3.28', 'USD'],
            [100, 'JPY', '26.96', 'TWD'],
            [100, 'JPY', '0.89', 'USD'],
            [100, 'USD', '3,044.40', 'TWD'],
            [100, 'USD', '11,180.10', 'JPY'],
        ];
    }

    public function error_input_provider()
    {
        return [
            [null , 'TWD', '366.90', 'JPY'],
            [100, 'TWDD', '3.28', 'USD'],
            [100, 'JPY', '26.96', 'USDD'],
            [100, null, '26.96', 'USDD'],
            [100, 'JPY', '26.96', null],
        ];
    }
}
