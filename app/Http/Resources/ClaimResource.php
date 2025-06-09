<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClaimResource extends JsonResource
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
            'amount' => $this->amount,
            'status' => $this->status,
            'type' => $this->type,
            'description' => $this->description,
            'submission_at' => $this->submission_at,

            // Computed properties
            'id' => $this->slug,
            'clientName' => $this->client->name,
            'clientId' => $this->client->slug,
            'statusLabel' => $this->status->label(),
            'typeLabel' => $this->type->label(),
            'amountString' => sprintf('%s%.2f', 'R', $this->amount),
            'submissionAt' => $this->submission_at->format('d/m/Y'),
        ];
    }
}