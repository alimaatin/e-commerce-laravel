<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use App\Http\Repositories\OrderRepository;
use App\Http\Services\OrderService;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function __construct(
        protected OrderRepository $orders,
        protected OrderService $orderservice,
    ){}

    public function index()
    {
        return Inertia::render('orders/index', [
            'orders' => $this->orders->getUserOrdersSorted(auth()->user()),
        ]);
    }
    public function show(Order $order)
    {
        if ($order->user_id !== auth()->user()->id) {
            return redirect()->route('orders');
        }

        $order->order_details;

        return Inertia::render('orders/show', [
            'order' => $order,
        ]);
    }
    public function store(StoreOrderRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->user()->id;
    
        $response = $this->orderservice->createOrder($validated);

        if ($response['data']['code'] == 100) {
            return Inertia::render('checkout/create', [
                'order' => $response,
                'redirect_url' => "https://sandbox.zarinpal.com/pg/StartPay/" . $response['data']['authority'],
            ]);
        } else {
            return Inertia::render('payment-failed', [
                'data' => $response,
            ]);
        }
    }

    public function verify(Request $request)
    {
        $authority = $request->Authority;
        $order = Order::where('authority', $authority)->first();
        $amount = $order->total_price * 10000;

        $zarinpalResponse = Http::withHeaders([
            'Accept' => 'application/json',
        ])->post('https://sandbox.zarinpal.com/pg/v4/payment/verify.json', [
            'merchant_id' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
            'amount' => $amount,
            'authority' => $authority,
        ]);

        $responseData = $zarinpalResponse->json();

        if (isset($responseData['data']) && $responseData['data']['code'] == 100) {
            $order->status = 'pending';
            foreach ($order->orderDetails as $detail) {
                $product = Product::find($detail->product_id);
                $product->stock -= $detail->quantity;
                $product->save();
            }
            $order->save();
            return Inertia::render('payment-verify', [
                'order' => $order,
                'responseData' => $responseData,
            ]);
        } else {
            $order->save();
            return Inertia::render('payment-failed', [
                'data' => $responseData,
            ]);
        }
    }
}
