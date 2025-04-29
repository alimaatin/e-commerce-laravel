<?php

namespace App\Http\Repositories;

use App\Models\Order;

class AdminOrderRepository
{
  public function getAllSorted()
  {
    return Order::orderByDesc('created_at')->get();
  }

  public function update(Order $order, array $data)
  {
    return $order->update($data);
  }  
}