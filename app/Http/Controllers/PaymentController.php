<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatusEnums;
use App\Http\Requests\StorePaymentRequest;
use App\Models\Payment;
use Illuminate\Support\Facades\Cache;
use \App\Http\Resources\PaymentResource;
use App\Notifications\PaymentApproved;

class PaymentController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        //$this->middleware([]);
        //$this->authorizeResource(Payment::class, 'payment');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return inertia()->render('Payments/Index', [
            'payments' => PaymentResource::collection(
                Cache::rememberForever('payments', function () {
                    return Payment::all();
                })
            ),
            'statuses' => PaymentStatusEnums::labels(),
            'payment' => session('payment') ?? null,
            'success' => session('success') ?? null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePaymentRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePaymentRequest $request)
    {
        $payment = Payment::create($request->validated());

        // Clear the cache to ensure the new payment is available
        Cache::forget('payments');
        Cache::forget('contributions');

        return redirect()->route('dashboard')
            ->with('success', 'Payment created successfully.')
            ->with('payment', new PaymentResource($payment));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Inertia\Response
     */
    public function show(Payment $payment)
    {
        return inertia()->render('Payments/Show', [
            'payment' => new PaymentResource($payment),
            'statuses' => PaymentStatusEnums::labels(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StorePaymentRequest  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StorePaymentRequest $request, Payment $payment)
    {
        $payment->update($request->validated());

        // Clear the cache to ensure the new payment is available
        Cache::forget('payments');
        Cache::forget('contributions');

        return redirect()->route('dashboard')
            ->with('success', 'Payment updated successfully.')
            ->with('payment', new PaymentResource($payment));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        // Clear the cache to ensure the new payment is available
        Cache::forget('payments');
        Cache::forget('contributions');

        return redirect()->route('dashboard')
            ->with('success', 'Payment deleted successfully.');
    }

    /**
     * Summary of approve
     * @param \App\Models\Payment $payment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(Payment $payment)
    {
        $payment->update([
            'status' => PaymentStatusEnums::PAID,
            'approved_at' => now()
        ]);

        // Send notifications (sms to client, database to user)
        $user = auth()->user();
        $user->notify(new PaymentApproved($payment));

        Cache::forget('payments');
        //Cache::forget('activeAccountsCount');
        //Cache::forget('monthlyContributionsSum');

        return redirect()->back()
            ->with('success', 'Payment processed successfully');
    }
}
