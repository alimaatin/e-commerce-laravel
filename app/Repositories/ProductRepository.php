<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function getAllActiveSorted()
    {
        return Product::where('is_active', true)->get();
    }
    public function getAllSorted()
    {
        return Product::orderByDesc('created_at')->get();
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data)
    {
        return $product->update($data);
    }

    public function decreamentStock(Product $product, $amount)
    {
        return Product::where('product_id', $product->id)->decrement('stock', $amount);
    }
}