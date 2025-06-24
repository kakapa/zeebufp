<?php

namespace App\Http\Resources;

use App\Models\Beneficiary;
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
            'client_id' => $this->client->slug,
            'payday' => $this->payday,
            'status' => $this->status,
            'total_coverage_amount' => $this->total_coverage_amount,
            'total_contribution_amount' => $this->total_contribution_amount,
            'last_payment_at' => $this->last_payment_at,
            'next_payment_at' => $this->next_payment_at,

            // Computed properties
            'id' => $this->slug,
            'mainPackage' => new PackageResource($this->packages()->where('main',true)->first()),
            'package_id' => $this->packages()->where('main',true)->first()->slug,
            'clientName' => sprintf(
                '%s %s %s',
                $this->client->title->label(),
                $this->client->firstname,
                $this->client->lastname
            ),
            'clientPhone' => $this->client->phone,
            'statusLabel' => $this->status->label(),
            'totalCoverageAmountString' => sprintf('%s%.2f', 'R', $this->total_coverage_amount),
            'totalContributionAmountString' => sprintf('%s%.2f', 'R', $this->total_contribution_amount),
            'lastPaymentAt' => $this->last_payment_at ? $this->last_payment_at->format('Y-m-d') : null,
            'nextPaymentAt' => $this->next_payment_at ? $this->next_payment_at->format('Y-m-d') : null,

            // Arrays
            'beneficiaries' => BeneficiaryResource::collection(Beneficiary::where('account_id',$this->id)->get()),
            'additionalPackages' => PackageResource::collection($this->packages()->where('main',false)->get()),
        ];
    }
}
