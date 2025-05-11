<?php

namespace App\Actions;

use App\Repositories\OrderRepository;
use App\Services\ZarinpalService;

class CreateOrderAction
{
  public function __construct(
    protected OrderRepository $orders,
    protected ZarinpalService $zarinpal,
  ){}

  public function handle(array $data)
  {
    $order = $this->orders->create($data);

    $order_details = json_decode($data["order"], true);

    $detail = [];

    foreach ($order_details as $order_detail) {
      $detail['order_id'] = $order->id;
      $detail['product_id'] = $order_detail['id'];
      $detail['quantity'] = $order_detail['quantity'];
      $detail['price'] = $order_detail['price'];
      $this->orders->createDetail($detail);
    }

    $zarinpalResponse = $this->zarinpal->create($order->toArray());

    if(!empty($responseData['data']) && $zarinpalResponse['data']['code'] == 100) {
        $this->orders->update($order, [
          'authority' => $zarinpalResponse['data']['authority'],
      ]);
    }

    return $zarinpalResponse;
  }
}
