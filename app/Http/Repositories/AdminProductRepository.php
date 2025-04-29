<?php

namespace App\Http\Repositories;

use App\Models\Product;

class AdminProductRepository 
{
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
}