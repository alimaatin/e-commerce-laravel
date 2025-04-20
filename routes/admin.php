<?php

use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('dashboard/admin', function () {
        return Inertia::render('admin/index', [
            'users' => User::all(),
            'products' => Product::all(),
            'orders' => Order::all(),
        ]);
    })->name('admin');


    Route::get('dashboard/admin/users', [UserController::class, 'index'])->name('admin.users');

    Route::get('dashboard/admin/users/{user}', [UserController::class, 'edit'])->name('admin.users.edit');
    
    Route::put('dashboard/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');


    Route::get('dashboard/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders');

    Route::get('dashboard/admin/orders/{order}', [AdminOrderController::class, 'edit'])->name('admin.orders.edit');

    Route::put('dashboard/admin/orders/{order}', [AdminOrderController::class, 'update'])->name('admin.orders.update');


    Route::get('dashboard/admin/products', [AdminProductController::class, 'index'])->name('admin.products');

    Route::get('dashboard/admin/products/create', function () {
        return Inertia::render('admin/products/create');
    })->name('admin.products.create');

    Route::post('dashboard/admin/products', [AdminProductController::class, 'store'])->name('admin.products.store');

    Route::get('dashboard/admin/products/{product}', function (Product $product) {
        return Inertia::render('admin/products/edit', ['product' => $product]);
    })->name('admin.products.edit');

    Route::post('dashboard/admin/products/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');

});