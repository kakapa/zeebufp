<?php

namespace App\Observers;

use App\Models\Activity;
use App\Models\Document;

class DocumentObserver
{
    /**
     * Handle the "retrieved" event.
     */
    public function retrieved(Document $document): void
    {
        //
    }

    /**
     * Handle the "creating" event.
     */
    public function creating(Document $document): void
    {
        //
    }

    /**
     * Handle the "created" event.
     */
    public function created(Document $document): void
    {
        // Store the activity
        Activity::create([
            'user_id' => auth()->id(),
            'activityable_id' => $document->id,
            'activityable_type' => $document::class,
            'new_record' => json_encode($document->getAttributes()),
            'type' => 'created',
        ]);
    }

    /**
     * Handle the "replicating" event.
     */
    public function replicating(Document $document): void
    {
        //
    }

    /**
     * Handle the "updating" event.
     */
    public function updating(Document $document): void
    {
        //
    }

    /**
     * Handle the "updated" event.
     */
    public function updated(Document $document): void
    {
        // Store old & new data before saving
        $oldRecord = $document->getOriginal();
        $newRecord = $document->getDirty();

        Activity::create([
            'user_id' => auth()->id(),
            'activityable_id' => $document->id,
            'activityable_type' => $document::class,
            'old_record' => json_encode($oldRecord),
            'new_record' => json_encode($newRecord),
            'type' => 'updated',
        ]);
    }

    /**
     * Handle the "saving" event.
     */
    public function saving(Document $document): void
    {
        //
    }

    /**
     * Handle the "saved" event.
     */
    public function saved(Document $document): void
    {
        //
    }

    /**
     * Handle the "trashed" event.
     * Only when SoftDeletes trait is being used.
     */
    public function trashed(Document $document): void
    {
        //
    }

    /**
     * Handle the "restoring" event.
     * Only when SoftDeletes trait is being used.
     */
    public function restoring(Document $document): void
    {
        //
    }

    /**
     * Handle the "restored" event.
     * Only when SoftDeletes trait is being used.
     */
    public function restored(Document $document): void
    {
        //
    }

    /**
     * Handle the "deleting" event.
     */
    public function deleting(Document $document): void
    {
        //
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(Document $document): void
    {
        // Store the activity
        Activity::create([
            'user_id' => auth()->id(),
            'activityable_id' => $document->id,
            'activityable_type' => $document::class,
            'old_record' => json_encode($document->getAttributes()),
            'type' => 'deleted',
        ]);
    }

    /**
     * Handle the "force deleted" event.
     * Only when SoftDeletes trait is being used.
     */
    public function forceDeleted(Document $document): void
    {
        //
    }
}
