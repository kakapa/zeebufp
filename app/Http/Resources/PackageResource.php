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
            'notes' => $this->notes,
            'status' => $this->status,
            'main' => (bool) $this->main,
            'popular' => (bool) $this->popular,

            // Ui labels and other mutated properties
            'id' => $this->slug,
            'featuresArray' => explode(', ', $this->features),
            'coverageAmountString' => sprintf('%s%.2f', 'R', $this->coverage),
            'monthlyContributionString' => sprintf('%s%.2f', 'R', $this->contribution),
            'monthlyContributionNoFloatString' => sprintf('%s%s', 'R', number_format($this->contribution, 0)),
            'subscribers' => $this->accounts()->count(),
            'statusLabel' => $this->status->label(),
        ];
    }
}