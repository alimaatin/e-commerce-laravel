<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminOrderController extends Controller
{

    public function index()
    {
        $orders = Order::all()->sortByDesc('created_at')->values();

        return Inertia::render('admin/orders/index', [
            'orders' => $orders
        ]);
    }

    public function edit(Order $order)
    {
        return Inertia::render('admin/orders/edit', [
            'order' => $order
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,completed',
        ]);

        $order->update($validated);
        return redirect()->route('admin.orders');
    }
}
