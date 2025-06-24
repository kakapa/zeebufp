<?php

namespace App\Enums;

enum AccountStatusEnums: string
{
    case ACTIVE = 'active';
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case SUSPENDED = 'suspended';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return [
            self::ACTIVE->value => 'Active',
            self::PENDING->value => 'Pending',
            self::PROCESSING->value => 'Processing',
            self::SUSPENDED->value => 'Suspended',
        ];
    }

    public function label(): string
    {
        return self::labels()[$this->value] ?? 'Unknown';
    }

    public static function optionsArray(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $enum) => [$enum->value => $enum->name])
            ->toArray();
    }
}