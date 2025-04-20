<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index() 
    {
        $products = Product::where('is_active', true)->get();
        Log::info($products);

        return Inertia::render('products/index', ['products' => $products]);
    }

    public function show(Product $product)
    {
        return Inertia::render('products/show', ['product' => $product]);
    }
}
