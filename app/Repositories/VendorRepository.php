<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;

class VendorRepository
{
  public function getBySeller(User $user)
  {
    return $user->vendors;
  }

  public function create(User $user, array $data)
  {
    return $user->vendors()->create($data);
  }

  public function createProduct(Vendor $vendor, array $data)
  {
    return $vendor->products()->create($data);
  }
}
