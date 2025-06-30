<?php

namespace App\Http\Requests;

use App\Enums\BeneficiaryRelationshipEnums;
use App\Enums\GenderEnums;
use App\Enums\UserStatusEnums;
use App\Models\Beneficiary;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreBeneficiaryRequest extends FormRequest
{
    /**
     * 1. Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        //$this->merge(['key' => 'value']);
    }

    /**
     * 2. Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * 3. Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'account_id' => [
                'required',
                'exists:accounts,slug',
            ],
            'firstname' => ['required', 'string', 'max:255'],
            'middlename' => ['nullable', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'id_number' => [
                'required',
                'digits:13',
                Rule::unique('beneficiaries', 'id_number')->ignore($this->route('beneficiary')),
            ],
            'phone' => [
                'nullable',
                'digits:10',
                'regex:/(0)[0-9]{9}/',
            ],
            'gender' => ['required', 'string', new Enum(GenderEnums::class)],
            'relationship' => ['required', 'string', new Enum(BeneficiaryRelationshipEnums::class)],
        ];
    }

    /**
     * 4. Post validation hook.
     */
    protected function passedValidation(): void
    {
        // Get the current validated data
        $validated = $this->validated();

        // Handle role
        if (array_key_exists('account_id', $validated)) {
            $validated['account_id'] = \App\Models\Account::where('slug', $validated['account_id'])->value('id');
        }

        // Replace the validated data with our modified version
        $this->replace($validated);
    }

    /**
     * 5. Add this method to ensure your changes are included in validated data
     */
    public function validated($key = null, $default = null)
    {
        return array_merge(parent::validated(), $this->all());
    }
}
