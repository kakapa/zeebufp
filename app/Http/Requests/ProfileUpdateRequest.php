<?php

namespace App\Http\Requests;

use App\Enums\EducationLevelEnums;
use App\Enums\GenderEnums;
use App\Enums\MaritalStatusEnums;
use App\Enums\SourceEnums;
use App\Enums\WorkStatusEnums;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fullnames' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'initials' => ['required', 'string', 'max:3'],
            'mobile_number' => [
                'required',
                'string',
                'min:10',
                'max:10',
                'regex:/(0)[0-9]{9}/',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            /* 'home_phone_number' => [
                'nullable',
                'string',
                'min:10',
                'max:10',
                'regex:/(0)[0-9]{9}/',
            ], */
            'email' => [
                'nullable',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'country_code' => ['required', 'string', 'exists:countries,code'],
            'id_number' => ['required', 'digits:13'],
            'home_address' => ['required', 'string', 'max:255'],
            'gender' => ['required', new Enum(GenderEnums::class)],
            'occupation' => ['required', 'exists:occupations,slug'],
            'marital_status' => ['required', new Enum(MaritalStatusEnums::class)],
            'work_status' => ['required', new Enum(WorkStatusEnums::class)],
            'education_level' => ['required', new Enum(EducationLevelEnums::class)],
            'disability' => ['boolean'],
            'about' => ['nullable', 'min:1', 'max:3000'],
            'source' => ['required', new Enum(SourceEnums::class)]
        ];
    }
}
