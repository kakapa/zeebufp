<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slug,
            'client_id' => $this->client_id,
            'payday' => $this->payday,
            'status' => $this->status,
            'total_coverage_amount' => $this->total_coverage_amount,
            'last_payment_at' => $this->last_payment_at,
            'next_payment_at' => $this->next_payment_at,

            // Computed properties
            'id' => $this->slug,
            'clientName' => sprintf(
                '%s %s %s',
                $this->client->title->label(),
                $this->client->firstname,
                $this->client->lastname
            ),
            'clientId' => $this->client->slug,
            'packageName' => $this->package->name,
            'totalCoverageAmountString' => sprintf('%s%.2f', 'R', $this->total_coverage_amount),
            'lastPaymentAt' => $this->last_payment_at ? $this->last_payment_at->format('Y-m-d') : null,
            'nextPaymentAt' => $this->next_payment_at ? $this->next_payment_at->format('Y-m-d') : null,
        ];
    }
}
