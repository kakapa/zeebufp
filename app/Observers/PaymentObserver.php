<?php

namespace App\Observers;

use App\Models\Activity;
use App\Models\Payment;

class PaymentObserver
{
    /**
     * Handle the "retrieved" event.
     */
    public function retrieved(Payment $payment): void
    {
        //
    }

    /**
     * Handle the "creating" event.
     */
    public function creating(Payment $payment): void
    {
        // Random slug
        do {
            $payment->slug = \Str::upper(
                sprintf('PY%s%s', mt_rand(100, 999), date('dHy'))
            );
        } while (Payment::where('slug', $payment->slug)->exists());
    }

    /**
     * Handle the "created" event.
     */
    public function created(Payment $payment): void
    {
        if (auth()->check()) {
            // Store the activity
            Activity::create([
                'user_id' => auth()->id(),
                'activityable_id' => $payment->id,
                'activityable_type' => $payment::class,
                'new_record' => json_encode($payment->getAttributes()),
                'type' => 'created',
            ]);
        }
    }

    /**
     * Handle the "replicating" event.
     */
    public function replicating(Payment $payment): void
    {
        //
    }

    /**
     * Handle the "updating" event.
     */
    public function updating(Payment $payment): void
    {
        //
    }

    /**
     * Handle the "updated" event.
     */
    public function updated(Payment $payment): void
    {
        // Store old & new data before saving
        $oldRecord = $payment->getOriginal();
        $newRecord = $payment->getDirty();

        if (auth()->check()) {
            Activity::create([
                'user_id' => auth()->id(),
                'activityable_id' => $payment->id,
                'activityable_type' => $payment::class,
                'old_record' => json_encode($oldRecord),
                'new_record' => json_encode($newRecord),
                'type' => 'updated',
            ]);
        }
    }

    /**
     * Handle the "saving" event.
     */
    public function saving(Payment $payment): void
    {
        //
    }

    /**
     * Handle the "saved" event.
     */
    public function saved(Payment $payment): void
    {
        //
    }

    /**
     * Handle the "trashed" event.
     * Only when SoftDeletes trait is being used.
     */
    public function trashed(Payment $payment): void
    {
        //
    }

    /**
     * Handle the "restoring" event.
     * Only when SoftDeletes trait is being used.
     */
    public function restoring(Payment $payment): void
    {
        //
    }

    /**
     * Handle the "restored" event.
     * Only when SoftDeletes trait is being used.
     */
    public function restored(Payment $payment): void
    {
        //
    }

    /**
     * Handle the "deleting" event.
     */
    public function deleting(Payment $payment): void
    {
        //
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(Payment $payment): void
    {
        if (auth()->check()) {
            // Store the activity
            Activity::create([
                'user_id' => auth()->id(),
                'activityable_id' => $payment->id,
                'activityable_type' => $payment::class,
                'old_record' => json_encode($payment->getAttributes()),
                'type' => 'deleted',
            ]);
        }
    }

    /**
     * Handle the "force deleted" event.
     * Only when SoftDeletes trait is being used.
     */
    public function forceDeleted(Payment $payment): void
    {
        //
    }
}