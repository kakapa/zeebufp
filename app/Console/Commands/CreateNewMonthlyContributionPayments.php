<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\Payment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CreateNewMonthlyContributionPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:create-new-monthly-contribution-payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron: Create new monthly contribution payments';

    /**
     * Indicates whether the command should be shown in the Artisan command list.
     *
     * @var bool
     */
    protected $hidden = false;

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Get all active accounts
        $accounts = DB::table('accounts')
            ->join('packages', 'accounts.package_id', '=', 'packages.id')
            ->select(
                'accounts.id as account_id',
                'accounts.next_payment_at',
                'accounts.payday',
                'packages.contribution'
            )
            //->where('accounts.status', 'active')
            ->cursor();

        foreach ($accounts as $account) {
            Payment::create([
                'account_id' => $account->account_id,
                'amount' => $account->contribution,
                'pay_at' => $account->next_payment_at
                    ? $account->next_payment_at
                    : now()->addMonth()->day($account->payday),
            ]);
        }

        Cache::forget('contributions');
        Cache::forget('payments');
    }
}