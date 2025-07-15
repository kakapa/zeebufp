<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'method' => $this->method,
            'reference' => $this->reference,
            'notes' => $this->notes,
            'paid_at' => $this->paid_at,
            'approved_at' => $this->approved_at,
            'created_at' => $this->created_at,

            // Computed properties
            'id' => $this->slug,
            'paidAt' => $this->paid_at ? $this->paid_at->format('Y-m-d H:i:s') : null,
            'createdAt' => $this->created_at->format('Y-m-d'),
            'approvedAt' => $this->approved_at ? $this->approved_at->format('Y-m-d H:i:s') : null,
            'accountId' => $this->account ? $this->account->slug : null,
            'clientName' => $this->account ? ($this->account->client ? $this->account->client->name : null) : null,
            'claimId' => $this->claim ? $this->claim->slug : null,
            'statusLabel' => $this->status->label(),
            'typeLabel' => $this->type->label(),
            'methodLabel' => $this->method->label(),
        ];
    }
}
