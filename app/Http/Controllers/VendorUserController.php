<?php

namespace App\Http\Controllers;

use App\Http\Requests\InviteVendorMemberRequest;
use App\Models\Vendor;
use App\Repositories\VendorRepository;
use App\Services\VendorService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VendorUserController extends Controller
{
    public function __construct(
        protected VendorRepository $vendors,
        protected VendorService $vendorService,
    ){}

    public function index(Vendor $vendor)
    {
        $invitations = $vendor->invitations;
        $members = $vendor->members;

        $users = $invitations->merge($members);

        foreach($users as $user) {
            $user->user;
        }

        return Inertia::render('seller/users/index', [
            'vendor' => $vendor,
            'users' => $users,
        ]);
    }

    public function create(Vendor $vendor)
    {
        return Inertia::render('seller/users/create', [
            'vendor' => $vendor,
        ]);
    }

    public function store(Vendor $vendor, InviteVendorMemberRequest $request)
    {
        $validated = $request->validated();

        $this->vendorService->inviteMember($vendor, $validated);

        return to_route('dashboard');
    }
}
