<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->user()->id)->get();
        return Inertia::render('orders/index', [
            'orders' => $orders,
        ]);
    }
    public function show(Order $order)
    {
        $order->order_details;

        if ($order->user_id !== auth()->user()->id) {
            return redirect()->route('orders');
        }

        return Inertia::render('orders/show', [
            'order' => $order,
        ]);
    }
    public function store(Request $request)
    {
       $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'postal_code' => 'required|numeric|digits:10',
        ]);
    
        $validated['user_id'] = auth()->user()->id;
    
        $order = Order::create($validated);
    
        $order_details = json_decode($request['order'], true);
    
        foreach ($order_details as $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }
    
        $amount = $order->total_price * 10000; 
    
        $zarinpalResponse = Http::withHeaders([
            'Accept' => 'application/json',
        ])->post('https://sandbox.zarinpal.com/pg/v4/payment/request.json', [
            'merchant_id' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
            'amount' => $amount,
            'callback_url' => route('payment.verify'),
            'description' => 'پرداخت سفارش شماره ' . $order->id,
            'metadata' => [
                'email' => $validated['email'],
                'order_id' => strval($order->id),
            ],
        ]);
    
        $responseData = $zarinpalResponse->json();

        if (isset($responseData['data']) && $responseData['data']['code'] == 100) {
            $order->authority = $responseData['data']['authority'];
            $order->save();

            return Inertia::render('checkout/create', [
                'order' => $order,
                'redirect_url' => "https://sandbox.zarinpal.com/pg/StartPay/" . $responseData['data']['authority'],
            ]);
        } else {
            return Inertia::render('payment-failed', [
                'data' => $responseData,
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
