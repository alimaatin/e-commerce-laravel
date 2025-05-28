<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Repositories\VendorRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VendorOrdersController extends Controller
{
    public function __construct(
        protected VendorRepository $vendors
    ){}

    public function index(Vendor $vendor)
    {
        return Inertia::render('seller/orders/index', [
            'orders' => $this->vendors->getOrders($vendor),
            'vendor' => $vendor
        ]);
    }
}
