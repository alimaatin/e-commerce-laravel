<?php

use App\Http\Controllers\OrderController;
use App\Models\Order;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'verified'])->group(function () {
  Route::get('dashboard', function () {
      return Inertia::render('dashboard', [
        'orders' => Order::where('user_id', auth()->user()->id)->get(),
      ]);
  })->name('dashboard');

  Route::get('dashboard/orders', [OrderController::class, 'index'])->name('orders');

  Route::get('dashboard/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});