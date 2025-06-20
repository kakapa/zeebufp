<?php

namespace App\Http\Requests;

use App\Enums\ClientGenderEnums;
use App\Enums\ClientSourceEnums;
use App\Enums\ClientStatusEnums;
use App\Enums\ClientTitleEnums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClientRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // You can pre-process or format inputs here if needed
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstname' => ['required', 'string', 'max:60'],
            'middlename' => ['nullable', 'string', 'max:60'],
            'title' => ['nullable', 'string', 'max:4', Rule::in(ClientTitleEnums::values())],
            'lastname' => ['required', 'string', 'max:60'],
            'email' => ['nullable', 'string', 'email', 'max:90', Rule::unique('clients', 'email')
                ->ignore($this->route('client'))],
            'id_number' => ['nullable', 'string', 'max:13', Rule::unique('clients', 'id_number')
                ->ignore($this->route('client'))],
            'gender' => ['nullable', 'string', 'max:10', Rule::in(ClientGenderEnums::values())],
            'phone' => ['nullable', 'string', 'max:15'],
            'address' => ['nullable', 'string', 'max:200'],
            'status' => ['required', 'string', 'max:20', Rule::in(ClientStatusEnums::values())],
            'notes' => ['nullable', 'string', 'max:300'],
            'profile_picture' => ['nullable', 'string', 'max:255'], // URL or path to the client's profile picture
            'referral_source' => ['nullable', 'string', 'max:50', Rule::in(ClientSourceEnums::values())], // e.g. ClientSourceEnums::FRIEND
        ];
    }
}
