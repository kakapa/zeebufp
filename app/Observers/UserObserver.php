<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the "retrieved" event.
     */
    public function retrieved(User $user): void
    {
        //
    }

    /**
     * Handle the "creating" event.
     */
    public function creating(User $user): void
    {
        // Random slug
        do {
            $user->slug = sprintf('C%s%s', date('dm'), strtoupper(\Str::random(5)));
        } while (User::where('slug', $user->slug)->exists());
    }

    /**
     * Handle the "created" event.
     */
    public function created(User $user): void
    {
        //
    }

    /**
     * Handle the "replicating" event.
     */
    public function replicating(User $user): void
    {
        //
    }

    /**
     * Handle the "updating" event.
     */
    public function updating(User $user): void
    {
        //
    }

    /**
     * Handle the "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the "saving" event.
     */
    public function saving(User $user): void
    {
        //
    }

    /**
     * Handle the "saved" event.
     */
    public function saved(User $user): void
    {
        //
    }

    /**
     * Handle the "trashed" event.
     * Only when SoftDeletes trait is being used.
     */
    public function trashed(User $user): void
    {
        //
    }

    /**
     * Handle the "restoring" event.
     * Only when SoftDeletes trait is being used.
     */
    public function restoring(User $user): void
    {
        //
    }

    /**
     * Handle the "restored" event.
     * Only when SoftDeletes trait is being used.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the "deleting" event.
     */
    public function deleting(User $user): void
    {
        //
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the "force deleted" event.
     * Only when SoftDeletes trait is being used.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
