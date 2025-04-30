<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ProductRepository;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function __construct(
        protected ProductRepository $products,
    ){}

    public function index() 
    {
        $products = $this->products->getAllSorted();

        return Inertia::render('products/index', ['products' => $products]);
    }

    public function show(Product $product)
    {
        return Inertia::render('products/show', ['product' => $product]);
    }
}
