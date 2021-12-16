<?php

namespace App\Lib;

class Currency
{
    private $amount;

    private $currency;

    private $exchangeRate;

    public function __construct($amount, $currrency, $exchangeRate) {
        $this->amount = $amount;
        $this->currency = $currrency;
        $this->exchangeRate = $exchangeRate;
    }

    public function convert($toCurrency)
    {
        $exchangeRate = $this->exchangeRate['currencies'][$this->currency][$toCurrency];
        $this->amount = round($this->amount * $exchangeRate, 2);
        $this->currency = $toCurrency;
        
        return $this;
    }

    public function getFormattedAmount()
    {
        return number_format($this->amount, 2);
    }

    public function getAmount()
    {
        return $this->amount;
    }
}