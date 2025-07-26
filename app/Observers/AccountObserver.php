<?php

namespace App\Observers;

use App\Models\Account;
use App\Models\Activity;

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
        if (auth()->check()) {
            // Store the activity
            Activity::create([
                'user_id' => auth()->id(),
                'activityable_id' => $account->id,
                'activityable_type' => $account::class,
                'new_record' => json_encode($account->getAttributes()),
                'type' => 'created',
            ]);
        }
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
        // Store old & new data before saving
        $oldRecord = $account->getOriginal();
        $newRecord = $account->getDirty();

        if (auth()->check()) {
            Activity::create([
                'user_id' => auth()->id(),
                'activityable_id' => $account->id,
                'activityable_type' => $account::class,
                'old_record' => json_encode($oldRecord),
                'new_record' => json_encode($newRecord),
                'type' => 'updated',
            ]);
        }
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
        if (auth()->check()) {
            // Store the activity
            Activity::create([
                'user_id' => auth()->id(),
                'activityable_id' => $account->id,
                'activityable_type' => $account::class,
                'old_record' => json_encode($account->getAttributes()),
                'type' => 'deleted',
            ]);
        }
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
