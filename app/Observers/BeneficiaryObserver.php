<?php

namespace App\Observers;

use App\Models\Activity;
use App\Models\Beneficiary;

class BeneficiaryObserver
{
    /**
     * Handle the "retrieved" event.
     */
    public function retrieved(Beneficiary $beneficiary): void
    {
        //
    }

    /**
     * Handle the "creating" event.
     */
    public function creating(Beneficiary $beneficiary): void
    {
        //
    }

    /**
     * Handle the "created" event.
     */
    public function created(Beneficiary $beneficiary): void
    {
        // Store the activity
        Activity::create([
            'user_id' => auth()->id(),
            'activityable_id' => $beneficiary->id,
            'activityable_type' => $beneficiary::class,
            'new_record' => json_encode($beneficiary->getAttributes()),
            'type' => 'created',
        ]);
    }

    /**
     * Handle the "replicating" event.
     */
    public function replicating(Beneficiary $beneficiary): void
    {
        //
    }

    /**
     * Handle the "updating" event.
     */
    public function updating(Beneficiary $beneficiary): void
    {
        //
    }

    /**
     * Handle the "updated" event.
     */
    public function updated(Beneficiary $beneficiary): void
    {
        // Store old & new data before saving
        $oldRecord = $beneficiary->getOriginal();
        $newRecord = $beneficiary->getDirty();

        Activity::create([
            'user_id' => auth()->id(),
            'activityable_id' => $beneficiary->id,
            'activityable_type' => $beneficiary::class,
            'old_record' => json_encode($oldRecord),
            'new_record' => json_encode($newRecord),
            'type' => 'updated',
        ]);
    }

    /**
     * Handle the "saving" event.
     */
    public function saving(Beneficiary $beneficiary): void
    {
        //
    }

    /**
     * Handle the "saved" event.
     */
    public function saved(Beneficiary $beneficiary): void
    {
        //
    }

    /**
     * Handle the "trashed" event.
     * Only when SoftDeletes trait is being used.
     */
    public function trashed(Beneficiary $beneficiary): void
    {
        //
    }

    /**
     * Handle the "restoring" event.
     * Only when SoftDeletes trait is being used.
     */
    public function restoring(Beneficiary $beneficiary): void
    {
        //
    }

    /**
     * Handle the "restored" event.
     * Only when SoftDeletes trait is being used.
     */
    public function restored(Beneficiary $beneficiary): void
    {
        //
    }

    /**
     * Handle the "deleting" event.
     */
    public function deleting(Beneficiary $beneficiary): void
    {
        //
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(Beneficiary $beneficiary): void
    {
        // Store the activity
        Activity::create([
            'user_id' => auth()->id(),
            'activityable_id' => $beneficiary->id,
            'activityable_type' => $beneficiary::class,
            'old_record' => json_encode($beneficiary->getAttributes()),
            'type' => 'deleted',
        ]);
    }

    /**
     * Handle the "force deleted" event.
     * Only when SoftDeletes trait is being used.
     */
    public function forceDeleted(Beneficiary $beneficiary): void
    {
        //
    }
}
