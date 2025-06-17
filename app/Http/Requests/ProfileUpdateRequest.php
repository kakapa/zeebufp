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
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'mobile_number' => [
                'required',
                'string',
                'min:10',
                'max:10',
                'regex:/(0)[0-9]{9}/',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
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
            'work_status' => ['required', new Enum(WorkStatusEnums::class)],
            'education_level' => ['required', new Enum(EducationLevelEnums::class)],
        ];
    }
}