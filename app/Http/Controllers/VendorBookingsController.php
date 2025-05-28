<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Repositories\VendorRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VendorBookingsController extends Controller
{
    public function __construct(
        protected VendorRepository $vendors
    ){}

    public function index(Vendor $vendor)
    {
        return Inertia::render('seller/bookings/index', [
            'bookings' => $this->vendors->getBookings($vendor),
            'vendor' => $vendor
        ]);
    }
}
