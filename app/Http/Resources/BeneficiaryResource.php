<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BeneficiaryResource extends JsonResource
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
            'id' => $this->id,
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,
            'lastname' => $this->lastname,
            'id_number' => $this->id_number,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'relationship' => $this->relationship,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // Computed properties
            'fullName' => $this->getFullName(),
            'relationshipLabel' => $this->relationship->label(),
            'genderLabel' => $this->gender?->label(),
            'createdAt' => $this->created_at->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updated_at->format('Y-m-d H:i:s'),
            'idNumberMasked' => $this->id_number ? substr($this->id_number, 0, 6) . '******' : null,
            'phoneFormatted' => $this->phone
                ? preg_replace('/(\d{3})(\d{3})(\d{4})/', '$1-$2-$3', $this->phone)
                : null,
        ];
    }

    protected function getFullName(): string
    {
        $parts = array_filter([
            $this->firstname,
            $this->middlename,
            $this->lastname
        ]);

        return implode(' ', $parts);
    }
}
