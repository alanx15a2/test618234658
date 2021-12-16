<?php

namespace App\Http\Controllers;

use App\Lib\Currency;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ExchangeRateController extends Controller
{
    public function show(Request $request)
    {
        // 驗證輸入
        $input = $request->validate([
            'fromCurrency' => ['required', Rule::in(['TWD', 'JPY', 'USD'])],
            'toCurrency' => ['required', Rule::in(['TWD', 'JPY', 'USD'])],
            'amount' => 'required|int|min:0',
        ]);

        // 取得匯率，這邊可以換成從 Model 或 Cache 等地方取
        $path = storage_path('app') . "/exchangeRate.json";
        if (!File::exists($path)) {
            throw new \Exception("Invalid File");
        }
        $exchangeRate = json_decode(File::get($path), true);

        // 建立 Currency 物件並轉換幣別
        $currency = new Currency($input['amount'], $input['fromCurrency'], $exchangeRate);
        $toAmount = $currency->convert($input['toCurrency'])->getFormattedAmount();
        return response()->json(['toAmount'=>$toAmount]);
    }
}
