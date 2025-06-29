<?php

namespace App\Observers;

use App\Models\Activity;
use App\Models\Client;

class ClientObserver
{
    /**
     * Handle the "retrieved" event.
     */
    public function retrieved(Client $client): void
    {
        //
    }

    /**
     * Handle the "creating" event.
     */
    public function creating(Client $client): void
    {
        // Random slug
        do {
            $client->slug = \Str::upper(
                sprintf('B%s', mt_rand(10000000, 99999999))
            );
        } while (Client::where('slug', $client->slug)->exists());
    }

    /**
     * Handle the "created" event.
     */
    public function created(Client $client): void
    {
        // Store the activity
        Activity::create([
            'user_id' => auth()->id(),
            'activityable_id' => $client->id,
            'activityable_type' => $client::class,
            'new_record' => json_encode($client->getAttributes()),
            'type' => 'created',
        ]);
    }

    /**
     * Handle the "replicating" event.
     */
    public function replicating(Client $client): void
    {
        //
    }

    /**
     * Handle the "updating" event.
     */
    public function updating(Client $client): void
    {
        //
    }

    /**
     * Handle the "updated" event.
     */
    public function updated(Client $client): void
    {
        // Store old & new data before saving
        $oldRecord = $client->getOriginal();
        $newRecord = $client->getDirty();

        Activity::create([
            'user_id' => auth()->id(),
            'activityable_id' => $client->id,
            'activityable_type' => $client::class,
            'old_record' => json_encode($oldRecord),
            'new_record' => json_encode($newRecord),
            'type' => 'updated',
        ]);
    }

    /**
     * Handle the "saving" event.
     */
    public function saving(Client $client): void
    {
        //
    }

    /**
     * Handle the "saved" event.
     */
    public function saved(Client $client): void
    {
        //
    }

    /**
     * Handle the "trashed" event.
     * Only when SoftDeletes trait is being used.
     */
    public function trashed(Client $client): void
    {
        //
    }

    /**
     * Handle the "restoring" event.
     * Only when SoftDeletes trait is being used.
     */
    public function restoring(Client $client): void
    {
        //
    }

    /**
     * Handle the "restored" event.
     * Only when SoftDeletes trait is being used.
     */
    public function restored(Client $client): void
    {
        //
    }

    /**
     * Handle the "deleting" event.
     */
    public function deleting(Client $client): void
    {
        //
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(Client $client): void
    {
        // Store the activity
        Activity::create([
            'user_id' => auth()->id(),
            'activityable_id' => $client->id,
            'activityable_type' => $client::class,
            'old_record' => json_encode($client->getAttributes()),
            'type' => 'deleted',
        ]);
    }

    /**
     * Handle the "force deleted" event.
     * Only when SoftDeletes trait is being used.
     */
    public function forceDeleted(Client $client): void
    {
        //
    }
}
