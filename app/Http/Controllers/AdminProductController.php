<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::all()->sortByDesc('created_at')->values();
        return Inertia::render('admin/products/index', [
            'products' => $products
        ]);
    }

    public function store(Request $request)
    {
        $valiated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required|numeric|min:5',
            'stock' => 'required|integer|min:0',
            'discount' => 'required|numeric|min:0|max:100',
        ]);

        $image = $request->file('image');
        $image->store('products', 'public');
        $valiated['image'] = $image->hashName();

        $product = Product::create($valiated);
        
        return redirect()->route('admin.products')->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {   
        return Inertia::render('admin/products/edit', [
            'product' => $product
        ]);
    }

    public function update(Request $request, Product $product)
    {
        Log::info('Update request data:', $request->all());
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:5',
            'stock' => 'sometimes|integer|min:0',
            'discount' => 'sometimes|numeric|min:0|max:100',
            'is_active' => 'sometimes|boolean',
        ]);
        Log::info('Validated data:', $validated);
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->store('products', 'public');
            $validated['image'] = $image->hashName();
        }
        
        $product->update($validated);
    
        return redirect()->route('admin.products')->with('success', 'Product updated successfully');
    }
}
