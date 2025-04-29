<?php

namespace App\Http\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;

class ZarinpalService
{
  public function create(array $data)
  {

    $amount = $data['total_price'] * 10000;

    $zarinpalResponse = Http::withHeaders([
      'Accept' => 'application/json',
    ])->post('https://sandbox.zarinpal.com/pg/v4/payment/request.json', [
        'merchant_id' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
        'amount' => $amount,
        'callback_url' => route('payment.verify'),
        'description' => 'پرداخت سفارش شماره ' . $data['id'],
        'metadata' => [
            'email' => $data['email'],
            'order_id' => strval($data['id']),
        ],
    ]);

    $responseData = $zarinpalResponse->json();

    return $responseData;
  }
}