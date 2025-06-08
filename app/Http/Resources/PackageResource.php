<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // Table columns
            'slug' => $this->slug,
            'name' => $this->name,
            'description' => $this->description,
            'contribution' => $this->contribution,
            'coverage' => $this->coverage,
            'features' => $this->features,
            'status' => $this->status,
            'main' => (bool) $this->main,

            // Ui labels and other mutated properties
            'id' => $this->slug,
            'featuresArray' => explode(', ', $this->features),
            'coverageAmountString' => sprintf('%s%.2f', 'R', $this->coverage),
            'monthlyContributionString' => sprintf('%s%.2f', 'R', $this->contribution),
            'subscribers' => 0, // Placeholder for subscribers count, adjust as needed
            'statusLabel' => $this->status->label(),

        ];
    }
}