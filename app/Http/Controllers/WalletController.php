<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBalanceRequest;
use App\Repositories\PaymentRepository;
use App\Services\ZarinpalService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WalletController extends Controller
{
    public function __construct(
        protected ZarinpalService $zarinpalService,
        protected PaymentRepository $payments
    ){}

    public function show()
    {
        return Inertia::render('wallet');
    }

    public function update(UpdateBalanceRequest $request)
    {
        $validated = $request->validated();

        $payment = $this->payments->create(auth()->user(), [
            'price' => $validated['balance'],
        ]);
        
        $response = $this->zarinpalService->create($payment);

        if ($this->zarinpalService->check($response)) {
            $this->payments->updateAuthority($payment, $response['data']['authority']);

            return Inertia::render('dashboard/checkout/create', [
            'order' => $response,
            'redirect_url' => "https://sandbox.zarinpal.com/pg/StartPay/" . $response['data']['authority'],
            ]);
        } else {
            return Inertia::render('payment-failed', [
                'data' => $response,
            ]);
        }
    }
}
