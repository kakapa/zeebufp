<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'id' => $this->slug,
            'slug' => $this->slug,
            'title' => $this->title,
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,
            'surname' => $this->surname,
            'email' => $this->email,
            'id_number' => $this->id_number,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'address' => $this->address,
            'status' => $this->status,
            'notes' => $this->notes,
            'profile_picture' => $this->profile_picture,
            'referral_source' => $this->referral_source,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // Computed properties
            'fullName' => $this->getFullName(),
            'statusLabel' => $this->status->label(),
            'genderLabel' => $this->gender?->label(),
            'titleLabel' => $this->title?->label(),
            'referralSourceLabel' => $this->referral_source?->label(),
            'createdAt' => $this->created_at->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updated_at->format('Y-m-d H:i:s'),
            'profilePictureUrl' => $this->profile_picture ? asset($this->profile_picture) : null,
            'idNumberMasked' => $this->id_number ? substr($this->id_number, 0, 6) . '******' : null,
            'phoneFormatted' => $this->phone
                ? preg_replace('/(\d{3})(\d{3})(\d{4})/', '$1-$2-$3', $this->phone)
                : null,
            'addressFormatted' => $this->address ? nl2br(e($this->address)) : null,
        ];
    }

    protected function getFullName(): string
    {
        $parts = array_filter([
            $this->title?->label(),
            $this->firstname,
            $this->middlename,
            $this->surname
        ]);

        return implode(' ', $parts);
    }
}
