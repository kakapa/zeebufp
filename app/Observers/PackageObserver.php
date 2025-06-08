<?php

namespace App\Observers;

use App\Models\Package;

class PackageObserver
{
    /**
     * Handle the "retrieved" event.
     */
    public function retrieved(Package $package): void
    {
        //
    }

    /**
     * Handle the "creating" event.
     */
    public function creating(Package $package): void
    {
        // Random slug
        do {
            $package->slug = \Str::upper(
                sprintf('PKG%s', mt_rand(100, 999))
            );
        } while (Package::where('slug', $package->slug)->exists());
    }

    /**
     * Handle the "created" event.
     */
    public function created(Package $package): void
    {
        //
    }

    /**
     * Handle the "replicating" event.
     */
    public function replicating(Package $package): void
    {
        //
    }

    /**
     * Handle the "updating" event.
     */
    public function updating(Package $package): void
    {
        //
    }

    /**
     * Handle the "updated" event.
     */
    public function updated(Package $package): void
    {
        //
    }

    /**
     * Handle the "saving" event.
     */
    public function saving(Package $package): void
    {
        //
    }

    /**
     * Handle the "saved" event.
     */
    public function saved(Package $package): void
    {
        //
    }

    /**
     * Handle the "trashed" event.
     * Only when SoftDeletes trait is being used.
     */
    public function trashed(Package $package): void
    {
        //
    }

    /**
     * Handle the "restoring" event.
     * Only when SoftDeletes trait is being used.
     */
    public function restoring(Package $package): void
    {
        //
    }

    /**
     * Handle the "restored" event.
     * Only when SoftDeletes trait is being used.
     */
    public function restored(Package $package): void
    {
        //
    }

    /**
     * Handle the "deleting" event.
     */
    public function deleting(Package $package): void
    {
        //
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(Package $package): void
    {
        //
    }

    /**
     * Handle the "force deleted" event.
     * Only when SoftDeletes trait is being used.
     */
    public function forceDeleted(Package $package): void
    {
        //
    }
}