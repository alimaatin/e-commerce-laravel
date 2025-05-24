<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\VendorInvitation;
use App\Services\VendorService;
use Illuminate\Http\Request;

class VendorInvitationController extends Controller
{
    public function __construct(
        protected VendorService $vendorService,
    ){}

    public function accept(VendorInvitation $vendor_invitation)
    {
        $this->vendorService->createMember($vendor_invitation);

        return to_route('notifications');
    }

    public function decline()
    {
        
    }
}
