<?php

namespace App\Http\Controllers;

use App\Services\Adyen\AdyenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Notification;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use Redirect;
use Session;
use URL;

class PaymentController extends Controller
{
    private $service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->service = new AdyenService();
    }

    public function index()
    {
        return view('payment');
    }

    public function processWebhook(Request $request)
    {
        //Code to process webhook
    }

    public function payWithAdyen(Request $request)
    {
        $payload = [
            "amount" => [
                "currency" => "USD",
                "value" => $request->amount
            ],
            "reference" => Str::random(16),
            "paymentMethod" => [
                "type" => "scheme",
                "encryptedCardNumber" => $request->cardNumber,
                "encryptedExpiryMonth" => $request->expiryMonth,
                "encryptedExpiryYear" => $request->expiryYear,
                "encryptedSecurityCode" => $request->cvv
            ],
            "returnUrl" => env('APP_URL'),
            "merchantAccount" => config('adyen.merchant_account')
        ];

        $responseData = $this->service->makeCardPayment($payload);
        //logger('Response: ', (array)$responseData);
        //dd($responseData);

        if ($responseData && isset($responseData->errorCode)) {
            return redirect()->back()->with('error', $responseData->message);
        }

        if($responseData->resultCode != 'Authorised')
        {
            return redirect()->back()->with('error', 'Sorry, there was an error processing your request');
        }

        //Send Order confirmation mail
        $email = auth()->user()->email;
        //Notification::route('mail', $email)->notify(new \App\Notifications\orderPaid($email));
        return redirect()->route('success');

    }

    public function success()
    {
        return view('success');
    }

}
