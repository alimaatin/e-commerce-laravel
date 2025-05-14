<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\VendorProductController;
use App\Models\Order;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'verified'])->group(function () {
  Route::get('dashboard', function () {
      return Inertia::render('dashboard', [
        'orders' => Order::where('user_id', auth()->user()->id)->get(),
      ]);
  })->name('dashboard');

  Route::get('dashboard/vendors', [VendorController::class, 'index'])->name('dashboard.vendors');

  Route::get('dashboard/orders', [OrderController::class, 'index'])->name('orders');

  Route::get('dashboard/orders/{order}', [OrderController::class, 'show'])->name('orders.show');


  Route::get('/seller-form', [VendorController::class, 'create'])->name('seller.create');

  Route::post('/seller-form', [VendorController::class, 'store'])->name('seller.store');


  Route::get('/seller/{vendor}', [VendorController::class, 'show'])->name('seller.dashboard');


  Route::get('/seller/{vendor}/products', [VendorProductController::class, 'index'])->name('seller.products');

  Route::get('/seller/{vendor}/products/create', [VendorProductController::class, 'create'])->name('seller.products.create');

  Route::post('/seller/{vendor}/products', [VendorProductController::class, 'store'])->name('seller.products.store');

  Route::get('/seller/{vendor}/{product}', [VendorProductController::class, 'edit'])->name('seller.products.edit');

  Route::post('/seller/{vendor}/{product}', [VendorProductController::class, 'update'])->name('seller.products.update');


  Route::get('/seller/{vendor}/reservations')->name('seller.products');

  Route::get('/seller/{vendor}/orders')->name('seller.products');

  Route::get('/seller/{vendor}/bookings')->name('seller.products');
});