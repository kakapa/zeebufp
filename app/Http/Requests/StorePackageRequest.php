<?php

namespace App\Http\Requests;

use App\Enums\PackageStatusEnums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePackageRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', Rule::unique('packages', 'name')
                ->ignore($this->route('package'))],
            'description' => ['required', 'string'],
            'contribution' => ['required', 'numeric', 'min:0'],
            'coverage' => ['required', 'numeric', 'min:0'],
            'features' => ['required', 'string'],
            'status' => ['required', Rule::in(PackageStatusEnums::values())],
            'main' => ['boolean'],
        ];
    }
}
