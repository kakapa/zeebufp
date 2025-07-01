<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class ValidDocumentableId implements ValidationRule
{
    protected array $data;

    /**
     * If you need other inputs (like documentable_type), implement DataAwareRule:
     *
     *     implements ValidationRule, \Illuminate\Contracts\Validation\DataAwareRule
     * and add:
     *     public function setData(array $data): void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Pull the type out of the data array
        $type = $this->data['documentable_type'] ?? null;

        $table = match ($type) {
            'client'  => 'clients',
            'account' => 'accounts',
            'payment' => 'payments',
            'claim'   => 'claims',
            default   => null,
        };

        if (! $table || ! DB::table($table)->where('slug', $value)->exists()) {
            $fail("The selected {$attribute} is invalid for the chosen type.");
        }
    }

    /**
     * If you need access to *all* other input values, implement DataAwareRule:
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }
}
