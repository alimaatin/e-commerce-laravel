<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\VendorRepository;

class VendorService
{
  public function __construct(
      protected VendorRepository $vendors
  ){}

  public function getBySeller()
  {
    $user = auth()->user();
    $vendors = $this->vendors->getBySeller($user);
    return $vendors;
  }

  public function create(array $data)
  {
    $user = auth()->user();
    $data['status'] = 'pending';
    return $this->vendors->create($user, $data);
  }

  public function createProduct(array $data)
  {
    
  }
}
