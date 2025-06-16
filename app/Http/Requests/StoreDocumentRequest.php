<?php

namespace App\Http\Requests;

use App\Enums\DocumentStatusEnums;
use App\Enums\DocumentTypeEnums;
use App\Enums\GenderEnums;
use App\Enums\UserStatusEnums;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreDocumentRequest extends FormRequest
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
            'file' => ['required', 'file'],
            'type' => ['required', 'string', new Enum(DocumentTypeEnums::class)],
            'status' => ['required', 'string', new Enum(DocumentStatusEnums::class)],
        ];
    }

    /**
     * 4. Post validation hook.
     */
    protected function passedValidation(): void
    {
        // Get the current validated data
        $validated = $this->validated();

        // Process file fields
        $file = $validated['file'];
        $extension = $file->getClientOriginalExtension();
        $filename = sprintf(
            '%s%s.%s',
            now()->format('YmdHis'),
            \Str::random(9),
            $extension
        );

        $validated['name'] = $filename;
        $validated['mime'] = $file->getMimeType();
        $validated['size'] = $file->getSize();

        // Store file
        $path = $file->storeAs('documents', $filename, 'public');
        $validated['path'] = Storage::disk('public')->url($path);

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