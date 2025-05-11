<?php

namespace App\Services;

use App\Events\OrderVerified;
use App\Repositories\OrderRepository;
use App\Models\Order;
use Illuminate\Support\Facades\Http;

//TODO
//Abstract requests, response checks and more

class ZarinpalService
{
  public function __construct(
    protected OrderRepository $orders,
  ){}

  public function create(array $data)
  {
    $amount = intval($data['total_price'] * 10000);

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

  public function verify(string $authority)
  {
    $order = $this->orders->getByAuthority($authority);
    $amount = intval($order->total_price * 10000);

    $zarinpalResponse = Http::withHeaders([
      'Accept' => 'application/json',
    ])->post('https://sandbox.zarinpal.com/pg/v4/payment/verify.json', [
        'merchant_id' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
        'amount' => $amount,
        'authority' => $authority,
    ]);

    $responseData = $zarinpalResponse->json();

    if(!empty($responseData['data']) && $responseData['data']['code'] == 100) {
      $this->orders->update($order, [
        'status' => 'pending',
      ]);
      event(new OrderVerified($order));
    }

    return [
        'order' => $order,
        'data' => $responseData['data'],
    ];
  }
}