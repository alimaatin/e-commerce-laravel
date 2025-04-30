<?php

namespace App\Http\Repositories;

use App\Models\Product;

class ProductRepository
{
  public function getAllSorted()
  {
    return Product::where('is_active', true)->get();
  }
}