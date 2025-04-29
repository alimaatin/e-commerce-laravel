<?php

namespace App\Http\Controllers;

use App\Http\Repositories\AdminOrderRepository;
use App\Http\Requests\AdminUpdateOrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminOrderController extends Controller
{
    public function __construct(
        protected AdminOrderRepository $orders,
    ){}

    public function index()
    {

        return Inertia::render('admin/orders/index', [
            'orders' => $this->orders->getAllSorted(),
        ]);
    }

    public function edit(Order $order)
    {
        return Inertia::render('admin/orders/edit', [
            'order' => $order
        ]);
    }

    public function update(AdminUpdateOrderRequest $request, Order $order)
    {
        $validated = $request->validated();

        $this->orders->update($order, $validated);
        return redirect()->route('admin.orders');
    }
}
