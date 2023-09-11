<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CurrencyConverter
{
    private $apiKey;
    protected $baseUrl = 'https://api.freecurrencyapi.com/v1';
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function convert(string $from,  $to, float $amount = 1): float
    {
        // $q = "{$from}_{$to}";
        $response = Http::baseUrl($this->baseUrl)
            ->get('/latest', [

                // 'q' => $q,
                // 'compact' => 'y',
                'apikey' => $this->apiKey,
                'base_currency' => $from,
                'currencies' => $to,
            ]);
        $result = $response->json();
        return $result['data'][$to] * $amount;
    }
}
