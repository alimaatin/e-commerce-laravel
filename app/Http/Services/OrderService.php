<?php

namespace App\Http\Services;

use App\Http\Repositories\OrderRepository;
use App\Http\Services\ZarinpalService;
use Illuminate\Support\Facades\Log;

class OrderService 
{

  public function __construct(
    protected OrderRepository $orders,
    protected ZarinpalService $zarinpal,
  ){}

  public function createOrder(array $data)
  {
    $order = $this->orders->create($data);

    foreach ($data["order"] as $order_detail) {
      $order_detail['order_id'] = $order->id;
      $this->orders->createDetail($order_detail);
    }

    $zarinpalResponse = $this->zarinpal->create($data);

    if ($zarinpalResponse) {
      $this->orders->update($data['order_id'], ['authority' => $zarinpalResponse]);
      return $zarinpalResponse;
    }

    return null;
  }
}