<?php

namespace App\Http\Controllers;

use App\Actions\CreateOrderAction;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Repositories\OrderRepository;
use App\Services\ZarinpalService;

class OrderController extends Controller
{
    public function __construct(
        protected OrderRepository $orders,
        protected CreateOrderAction $createOrder,
        protected ZarinpalService $zarinpal
    ){}

    public function index()
    {
        return Inertia::render('dashboard/orders/index', [
            'orders' => $this->orders->getUserOrdersSorted(auth()->user()),
        ]);
    }
    public function show(Order $order)
    {
        if ($order->user_id !== auth()->user()->id) {
            return redirect()->route('orders');
        }

        $order->order_details;

        return Inertia::render('dashboard/orders/show', [
            'order' => $order,
        ]);
    }
    public function store(StoreOrderRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->user()->id;

        $response = $this->createOrder->handle($validated);

        if (!empty($responseData['data']) && $response['data']['code'] == 100) {
            return Inertia::render('dashboard/checkout/create', [
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
        $responseData = $this->zarinpal->verify($request->Authority);
        if (!empty($responseData['data']) && $responseData['data']['code'] == 100) {
            return Inertia::render('payment-verify', [
                'order' => $responseData['order'],
                'responseData' => $responseData['data'],
            ]);
        } else {
            return Inertia::render('payment-failed', [
                'data' => $responseData,
            ]);
        }
    }
}
