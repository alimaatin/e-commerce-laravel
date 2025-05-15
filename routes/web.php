<?php

use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [ProductController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('checkout', function () {
        return Inertia::render('dashboard/checkout/index');
    })->name('checkout');

    Route::post('checkout/create', [OrderController::class, 'store'])->name('checkout.create');

    Route::get('checkout/create/{order}', function (Order $order) {
        return Inertia::render('dashboard/checkout/create', ['order' => $order]);
    })->name('checkout.create.show');

    Route::get('payment/verify', [OrderController::class, 'verify'])->name('payment.verify');

    Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');

    Route::get('products', [ProductController::class, 'index'])->name('products');

    Route::get('/reservations', [ReservationController::class, 'index']);

    Route::get('/reservations/{reservation}', [ReservationController::class, 'show']);

    Route::post('/reservations/{reservation}', [BookingController::class, 'store']);

    Route::get('/vendors');

    Route::get('/vendors/{vendor}');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/dashboard.php';