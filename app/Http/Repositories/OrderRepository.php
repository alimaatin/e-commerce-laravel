<?php

namespace App\Http\Repositories;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;

class OrderRepository
{
  public function getUserOrdersSorted(?User $user)
  {
    return Order::where("user_id", $user->id)->orderByDesc("created_at")->get();
  }

  public function create(array $data)
  {
    return Order::create($data);
  }

  public function createDetail(array $data)
  {
    return OrderDetail::create($data);
  }

  public function update(Order $order, array $data)
  {
    return $order->update($data);
  }
}