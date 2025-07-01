<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {// Debugging line to inspect the documentable relationship
        // figure out what property to show on each related model
        $related = $this->whenLoaded('documentable', function () {
            $model = $this->documentable;
            return match (class_basename($this->documentable_type)) {
                'Client'  => $model->name,
                'Account' => $model->slug,
                'Payment' => $model->slug,
                'Claim'   => $model->slug,
                default   => $model->id,
            };
        });

        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'status' => $this->status,
            'path' => $this->path,
            'size' => $this->size,
            'mime' => $this->mime,
            'views' => $this->views,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'documentable_id' => $this->documentable_id,
            'documentable_type' => class_basename($this->documentable_type),

            // Computed properties
            'relatedLabel' => $related ?? null,
            'typeLabel' => $this->type->label(),
            'statusLabel' => $this->status->label(),
            'sizeFormatted' => $this->formatSize($this->size),
            'createdAt' => $this->created_at->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    private function formatSize($size): string
    {
        if ($size >= 1048576) {
            return number_format($size / 1048576, 2) . ' MB';
        } elseif ($size >= 1024) {
            return number_format($size / 1024, 2) . ' KB';
        } else {
            return $size . ' bytes';
        }
    }
}
