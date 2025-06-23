<?php

namespace App\Http\Requests;

use App\Enums\GenderEnums;
use App\Enums\UserStatusEnums;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreAccountRequest extends FormRequest
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
            'client_id' => ['required', 'exists:clients,slug'],
            'package_id' => ['required', 'exists:packages,slug'],
            'payday' => ['required', 'numeric', 'min:1', 'max:31'],
            'notes' => ['nullable', 'min:1', 'max:1000'],
        ];
    }

    /**
     * 4. Post validation hook.
     */
    protected function passedValidation(): void
    {
        // Get the current validated data
        $validated = $this->validated();

        // Handle client
        if (array_key_exists('client_id', $validated)) {
            $validated['client_id'] = \App\Models\Client::where('slug', $validated['client_id'])->value('id');
        }

        // Handle package
        if (array_key_exists('package_id', $validated)) {
            $package = \App\Models\Package::where('slug', $validated['package_id'])->first();
            $validated['package_id'] = $package->id;

            if($this->isMethod('post')) {
                $validated['total_contribution_amount'] = $package->contribution;
                $validated['total_coverage_amount'] = $package->coverage;
            } elseif($this->isMethod('put') || $this->isMethod('patch')) {
                $account = $this->route('account');

                // TODO: Modify values along with any additional packages here
                $validated['total_contribution_amount'] = $package->contribution;
                $validated['total_coverage_amount'] = $package->coverage;
            }
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