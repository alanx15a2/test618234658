<?php

namespace Tests\Unit;

use App\Lib\Currency;
use PHPUnit\Framework\TestCase;

class CurrencyTest extends TestCase
{
    /**
     * @dataProvider exchange_provider
     */
    public function test_convert($fromAmount, $fromCurrency, $toAmount, $toCurrency)
    {
        $json = '
        {
            "currencies": {
                "TWD": {
                    "TWD": 1,
                    "JPY": 3.669,
                    "USD": 0.03281
                },
                "JPY": {
                    "TWD": 0.26956,
                    "JPY": 1,
                    "USD": 0.00885
                },
                "USD": {
                    "TWD": 30.444,
                    "JPY": 111.801,
                    "USD": 1
                }
            }
        }';

        $exchange_rate = json_decode($json, true);
        $currency = new Currency($fromAmount, $fromCurrency, $exchange_rate);
        $amount = $currency->convert($toCurrency)->getAmount();
        $this->assertEquals($toAmount, $amount);
    }

    /**
     * @dataProvider format_provider
     */
    public function test_format($amount, $formattedAmount)
    {
        $currency = new Currency($amount, 'TWD', null);
        $this->assertEquals($formattedAmount, $currency->getFormattedAmount());
    }

    public function exchange_provider()
    {
        return [
            [100, 'TWD', 366.9, 'JPY'],
            [100, 'TWD', 3.28, 'USD'],
            [100, 'JPY', 26.96, 'TWD'],
            [100, 'JPY', 0.89, 'USD'],
            [100, 'USD', 3044.4, 'TWD'],
            [100, 'USD', 11180.1, 'JPY'],
        ];
    }

    public function format_provider()
    {
        return [
            [1234, '1,234.00'],
            [1234.56, '1,234.56'],
            [12345.678, '12,345.68'],
            [12345.671, '12,345.67'],
            [0, '0.00'],
            [100.9, '100.90'],
        ];
    }
}
