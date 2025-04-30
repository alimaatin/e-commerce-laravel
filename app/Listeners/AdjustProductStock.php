<?php

namespace App\Listeners;

use App\Events\OrderVerified;
use App\Http\Repositories\AdminProductRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AdjustProductStock
{
    /**
     * Create the event listener.
     */
    public function __construct(
        protected AdminProductRepository $products,
    ){}

    /**
     * Handle the event.
     */
    public function handle(OrderVerified $event): void
    {
        $order_details = $event->order->orderDetails;
        foreach($order_details as $order_detail){
            $this->products->decreamentStock($order_detail->product, $order_detail->quantity);
        }
    }
}
