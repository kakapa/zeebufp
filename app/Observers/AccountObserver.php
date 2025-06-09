<?php

namespace App\Observers;

use App\Models\Account;

class AccountObserver
{
    /**
     * Handle the "retrieved" event.
     */
    public function retrieved(Account $account): void
    {
        //
    }

    /**
     * Handle the "creating" event.
     */
    public function creating(Account $account): void
    {
        // Random slug
        do {
            $account->slug = \Str::upper(
                sprintf('ZEB%s%s%s', date('ymd'), \Str::random(2), mt_rand(100, 999))
            );
        } while (Account::where('slug', $account->slug)->exists());
    }

    /**
     * Handle the "created" event.
     */
    public function created(Account $account): void
    {
        //
    }

    /**
     * Handle the "replicating" event.
     */
    public function replicating(Account $account): void
    {
        //
    }

    /**
     * Handle the "updating" event.
     */
    public function updating(Account $account): void
    {
        //
    }

    /**
     * Handle the "updated" event.
     */
    public function updated(Account $account): void
    {
        //
    }

    /**
     * Handle the "saving" event.
     */
    public function saving(Account $account): void
    {
        //
    }

    /**
     * Handle the "saved" event.
     */
    public function saved(Account $account): void
    {
        //
    }

    /**
     * Handle the "trashed" event.
     * Only when SoftDeletes trait is being used.
     */
    public function trashed(Account $account): void
    {
        //
    }

    /**
     * Handle the "restoring" event.
     * Only when SoftDeletes trait is being used.
     */
    public function restoring(Account $account): void
    {
        //
    }

    /**
     * Handle the "restored" event.
     * Only when SoftDeletes trait is being used.
     */
    public function restored(Account $account): void
    {
        //
    }

    /**
     * Handle the "deleting" event.
     */
    public function deleting(Account $account): void
    {
        //
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(Account $account): void
    {
        //
    }

    /**
     * Handle the "force deleted" event.
     * Only when SoftDeletes trait is being used.
     */
    public function forceDeleted(Account $account): void
    {
        //
    }
}