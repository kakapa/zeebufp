<?php

namespace App\Http\Requests;

use App\Enums\GenderEnums;
use App\Enums\PaymentMethodEnums;
use App\Enums\UserStatusEnums;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StorePaymentRequest extends FormRequest
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
            'amount' => ['required', 'numeric', 'min:1', 'max:1000'],
            'reference' => ['required', 'string', 'max:255'],
            'account_id' => ['nullable', 'exists:accounts,slug'],
            'method' => ['required', 'string', new Enum(PaymentMethodEnums::class)],
            'notes' => ['nullable', 'min:1', 'max:300'],
        ];
    }

    /**
     * 4. Post validation hook.
     */
    protected function passedValidation(): void
    {
        // Get the current validated data
        $validated = $this->validated();

        // Handle account
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