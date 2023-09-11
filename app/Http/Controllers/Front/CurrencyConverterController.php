<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\CurrencyConverter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CurrencyConverterController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'currency_code' => ['required', 'string', 'size:3'],
        ]);

        $baseCurrencyCode = config('app.currency');
        $currency_code = $request->input('currency_code');
        $cacheKey = 'currency_rate_' . $currency_code;

        $rate = Cache::get($cacheKey, 0);

        if (!$rate) {
            $converter = app('currency.converter');
            $rate = $converter->convert($baseCurrencyCode, $currency_code);

            Cache::put($cacheKey, $rate, now()->addMinutes(60));
        }

        Session::put('currency_code', $currency_code);

        return redirect()->back();
    }
}
