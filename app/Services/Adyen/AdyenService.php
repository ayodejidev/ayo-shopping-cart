<?php

namespace App\Services\Adyen;

use Illuminate\Support\Facades\Http;

class AdyenService
{
    public function getPaymentMethods($amount): object
    {
        $url = config('adyen.root_url') . 'paymentMethods';
        $payload = [
            "merchantAccount" => config('adyen.merchant_account'),
            "countryCode" => "USD",
            "shopperLocale" => "en-US",
            "channel" => "Web",
            "amount" => [
                "currency" => "USD",
                "value" => $amount
            ]
        ];

        return Http::timeout(40)->withHeaders([
            "x-API-key" => config('adyen.api_key'),
            "content-type" => "application/json"
        ])->post($url, $payload)->object();
    }

    public function makeCardPayment($payload)
    {
        $url = config('adyen.root_url') . 'payments';
        return Http::withHeaders([
            "x-API-key" => config('adyen.api_key'),
            "content-type" => "application/json"
        ])->post($url, $payload)->object();
    }
}
