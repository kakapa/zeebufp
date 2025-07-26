<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\Payment;
use App\Notifications\PaymentReminder;
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
            ->where('status', 'active')
            ->cursor();

        foreach ($accounts as $account) {
            $currentAccount = Account::where('id', $account->id)->first();

            if ($currentAccount) {
                // Get last payment of $currentAccount
                $lastPayment = Payment::where('account_id', $currentAccount->id)
                    ->where('status', 'paid')
                    ->orderBy('paid_at', 'desc')
                    ->first();

                // If there is last payment exist
                if ($lastPayment) {
                    $this->processLastPayment($lastPayment, $currentAccount);
                }
            }
        }

        $this->info('Finished processing all accounts.');

        // Clear cache for contributions and payments
        Cache::forget('contributions');
        Cache::forget('payments');
    }

    /**
     * Process the last payment to determine if a new payment should be created.
     *
     * @param  Payment  $lastPayment
     * @param  Account  $currentAccount
     * @return void
     */
    protected function processLastPayment($lastPayment, $currentAccount)
    {
        if (
            $lastPayment->paid_at
                ? $lastPayment->paid_at->copy()->addDays(20)->lt(now())
                : $lastPayment->created_at->copy()->addDays(20)->lt(now())
        ) {
            $this->createPayment($currentAccount);
        }
    }

    protected function getNextValidPayDate($currentAccount, $currentDate = null)
    {
        $now = $currentDate ?? now()->addMonth();
        $day = $currentAccount->payday;

        // Get number of days in the current month
        $daysInMonth = $now->daysInMonth;

        if ($day <= $daysInMonth) {
            // Do something with $date
            return $now->copy()->setDay($day);
        } else {
            // Day is invalid for this month
            return $now->copy()->lastOfMonth();
        }
    }

    /**
     * Summary of createPayment
     *
     * @param  mixed  $account
     * @return Payment
     */
    protected function createPayment($account)
    {
        // Check for any pending payments first
        $pendingPaymentCount = Payment::where('account_id', $account->id)
            ->where('status', 'pending')
            ->count();

        // Get next valid pay date
        $nextPayDate = $account->next_payment_at ?? $this->getNextValidPayDate($account);
        $diff = now()->diffInRealDays($nextPayDate, false);

        // If no pending payments && $nextPayDate is due within 9 days
        if ($pendingPaymentCount == 0 && $diff <= 9) {
            // Create a new payment
            $payment = Payment::create([
                'account_id' => $account->id,
                'amount' => $account->total_contribution_amount,
                'due_at' => $nextPayDate,
            ]);

            // Send Notification
            $account->client->notify(new PaymentReminder($payment->refresh()));

            // Set next pay
            if ($payment) {
                $account->update([
                    'next_payment_at' => $this->getNextValidPayDate($account, $nextPayDate->copy()->addMonth()),
                ]);
            }

            return $payment;
        }

        return null;
    }
}
