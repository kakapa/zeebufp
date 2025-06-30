<?php

namespace App\Observers;

use App\Models\Activity;
use App\Models\Claim;

class ClaimObserver
{
    /**
     * Handle the "retrieved" event.
     */
    public function retrieved(Claim $claim): void
    {
        //
    }

    /**
     * Handle the "creating" event.
     */
    public function creating(Claim $claim): void
    {
        // Random slug
        do {
            $claim->slug = \Str::upper(
                sprintf('CZ%s', mt_rand(100000, 999999))
            );
        } while (Claim::where('slug', $claim->slug)->exists());
    }

    /**
     * Handle the "created" event.
     */
    public function created(Claim $claim): void
    {
        // Store the activity
        Activity::create([
            'user_id' => auth()->id(),
            'activityable_id' => $claim->id,
            'activityable_type' => $claim::class,
            'new_record' => json_encode($claim->getAttributes()),
            'type' => 'created',
        ]);
    }

    /**
     * Handle the "replicating" event.
     */
    public function replicating(Claim $claim): void
    {
        //
    }

    /**
     * Handle the "updating" event.
     */
    public function updating(Claim $claim): void
    {
        //
    }

    /**
     * Handle the "updated" event.
     */
    public function updated(Claim $claim): void
    {
        // Store old & new data before saving
        $oldRecord = $claim->getOriginal();
        $newRecord = $claim->getDirty();

        Activity::create([
            'user_id' => auth()->id(),
            'activityable_id' => $claim->id,
            'activityable_type' => $claim::class,
            'old_record' => json_encode($oldRecord),
            'new_record' => json_encode($newRecord),
            'type' => 'updated',
        ]);
    }

    /**
     * Handle the "saving" event.
     */
    public function saving(Claim $claim): void
    {
        //
    }

    /**
     * Handle the "saved" event.
     */
    public function saved(Claim $claim): void
    {
        //
    }

    /**
     * Handle the "trashed" event.
     * Only when SoftDeletes trait is being used.
     */
    public function trashed(Claim $claim): void
    {
        //
    }

    /**
     * Handle the "restoring" event.
     * Only when SoftDeletes trait is being used.
     */
    public function restoring(Claim $claim): void
    {
        //
    }

    /**
     * Handle the "restored" event.
     * Only when SoftDeletes trait is being used.
     */
    public function restored(Claim $claim): void
    {
        //
    }

    /**
     * Handle the "deleting" event.
     */
    public function deleting(Claim $claim): void
    {
        //
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(Claim $claim): void
    {
        // Store the activity
        Activity::create([
            'user_id' => auth()->id(),
            'activityable_id' => $claim->id,
            'activityable_type' => $claim::class,
            'old_record' => json_encode($claim->getAttributes()),
            'type' => 'deleted',
        ]);
    }

    /**
     * Handle the "force deleted" event.
     * Only when SoftDeletes trait is being used.
     */
    public function forceDeleted(Claim $claim): void
    {
        //
    }
}
