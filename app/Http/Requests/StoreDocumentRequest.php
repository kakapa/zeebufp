<?php

namespace App\Http\Requests;

use App\Enums\DocumentStatusEnums;
use App\Enums\DocumentTypeEnums;
use App\Rules\ValidDocumentableId;
use App\Services\S3Service;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreDocumentRequest extends FormRequest
{
    private $s3;

    public function __construct(S3Service $s3)
    {
        parent::__construct();
        $this->s3 = $s3;
    }

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
            'documentable_id' => ['required'/* ,  new ValidDocumentableId() */],
            'documentable_type' => [
                'required',
                'string',
                Rule::in([
                    'Client',
                    'Account',
                    'Payment',
                    'Claim',
                ]),
            ],
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

        // Get correct model id for documentable_id
        if ($validated['documentable_id'] && $validated['documentable_type']) {
            $validated['documentable_type'] = sprintf('\App\Models\%s', $validated['documentable_type']);
            $validated['documentable_id'] = $validated['documentable_type']::where('slug', $validated['documentable_id'])->firstOrFail()->id;
        }

        // Store file
        $folder = 'zeebundelwa/documents/'.$validated['type'];
        $validated['path'] = $this->s3->storeFile($folder, $file, $filename);

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