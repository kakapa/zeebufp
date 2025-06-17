<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Spatie\LaravelPdf\Facades\Pdf;
use Illuminate\Support\Facades\Cache;
use App\Enums\AccountStatusEnums;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Resources\AccountResource;

class AccountController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        //$this->middleware([]);
        //$this->authorizeResource(Account::class, 'account');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return inertia()->render('Accounts/Index', [
            'accounts' => AccountResource::collection(
                Cache::rememberForever('accounts', function () {
                    return Account::all();
                })
            ),
            'statuses' => AccountStatusEnums::labels(),
            'account' => session('account') ?? null,
            'success' => session('success') ?? null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAccountRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAccountRequest $request)
    {
        $account = Account::create($request->validated());

        // Clear the cache to ensure the new account is available
        Cache::forget('accounts');
        Cache::forget('activeAccountsCount');
        Cache::forget('monthlyContributionsSum');

        return redirect()->route('dashboard')
            ->with('success', 'Account created successfully.')
            ->with('account', new AccountResource($account));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Inertia\Response
     */
    public function show(Account $account)
    {
        return inertia()->render('Accounts/Show', [
            'account' => new AccountResource($account),
            'statuses' => AccountStatusEnums::labels(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreAccountRequest  $request
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreAccountRequest $request, Account $account)
    {
        $account->update($request->validated());

        // Clear the cache to ensure the new account is available
        Cache::forget('accounts');
        Cache::forget('activeAccountsCount');
        Cache::forget('monthlyContributionsSum');

        return redirect()->route('dashboard')
            ->with('success', 'Account updated successfully.')
            ->with('account', new AccountResource($account));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Account $account)
    {
        $account->delete();

        // Clear the cache to ensure the new account is available
        Cache::forget('accounts');
        Cache::forget('activeAccountsCount');
        Cache::forget('monthlyContributionsSum');

        return redirect()->route('dashboard')
            ->with('success', 'Account deleted successfully.');
    }

    public function downloadTerms(Account $account)
    {
        $beneficiaries = [
            ['name' => 'Jane Doe', 'id' => '8001015009087', 'relationship' => 'Spouse', 'dob' => '1980-01-01', 'contact' => '0812345678'],
            ['name' => 'John Doe Jr.', 'id' => '2005015009087', 'relationship' => 'Child', 'dob' => '2005-01-01', 'contact' => '0812345679'],
        ];

        return Pdf::view('pdf.accounts.terms', ['beneficiaries' => $beneficiaries])
            ->format('A4')
            ->name(sprintf('%s_%s_funeral-terms.pdf', $account->slug, date('ymdhs')))
            ->download();
    }
}