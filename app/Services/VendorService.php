<?php

namespace App\Services;

use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorInvitation;
use App\Models\VendorMember;
use App\Repositories\VendorRepository;
use Illuminate\Validation\ValidationException;

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

  public function create(User $user, array $data)
  {
    return $this->vendors->create($user, $data);
  }

  public function inviteMember(Vendor $vendor, array $data)
  {
    // $invitation = VendorInvitation::where('email', $data['email'])->first();
    // $member = VendorMember::where('email', $data['email'])->first();

    // if($invitation || $member) {
    //   throw ValidationException::withMessages([
    //     'email' => ['The user has already been invited to the vendor.']
    //   ]);
    // }

    $user = User::where('email', $data['email'])->firstOrFail();

    return $this->vendors->createInvitation($vendor, [
      'user_id' => $user->id,
      'email' => $data['email'],
    ]);
  }
}
