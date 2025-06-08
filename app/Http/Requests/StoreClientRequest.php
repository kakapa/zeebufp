<?php

namespace App\Http\Requests;

use App\Enums\ClientGenderEnums;
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
            'firstname' => ['required', 'string', 'max:255'],
            'middlename' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:50', Rule::in(ClientTitleEnums::values())],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique('clients', 'email')
                ->ignore($this->route('client'))],
            'id_number' => ['nullable', 'string', 'max:20', Rule::unique('clients', 'id_number')
                ->ignore($this->route('client'))],
            'gender' => ['nullable', 'string', 'max:10', Rule::in(ClientGenderEnums::values())],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:20', Rule::in(ClientStatusEnums::values())],
            'notes' => ['nullable', 'string'],
            'profile_picture' => ['nullable', 'string', 'max:255'], // URL or path to the client's profile picture
            'referral_source' => ['nullable', 'string', 'max:50'], // e.g. ClientSourceEnums::FRIEND
        ];
    }
}