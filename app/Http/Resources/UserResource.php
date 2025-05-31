<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'role' => $this->role->slug,
            'role_label' => $this->role->label,
            'name' => $this->name,
            'initials' => $this->initials,
            'fullnames' => $this->fullnames,
            'surname' => $this->surname,
            'country' => $this->country->name,
            'country_code' => $this->country->code,
            'mobile_number' => $this->mobile_number,
            //'home_phone_number' => $this->home_phone_number,
            'id_number' => $this->id_number,
            'email' => $this->email,
            'home_address' => $this->home_address,
            'status' => $this->status,
            'gender' => $this->gender,
            'occupation' => $this->occupation ? $this->occupation->slug : null,
            'occupation_label' => $this->occupation ? $this->occupation->label : null,
            'marital_status' => $this->marital_status,
            'work_status' => $this->work_status,
            'education_level' => $this->education_level,
            'disability' => $this->disability,
            'about' => $this->about,
            'source' => $this->source,
            'email_verified_at' => $this->email_verified_at ? $this->email_verified_at->format('Y-m-d H:i:s') : null,
            'mobile_verified_at' => $this->mobile_verified_at ? $this->mobile_verified_at->format('Y-m-d H:i:s') : null,
            'profiled_at' => $this->profiled_at ? $this->profiled_at->format('Y-m-d H:i:s') : null,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
