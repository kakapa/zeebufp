<?php

namespace App\Enums;

enum StructureStatusEnums: string
{
    case ACTIVE = 'active';
    case SUSPENDED = 'suspended';
    case CLOSED = 'closed';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return [
            self::ACTIVE->value => 'Active',
            self::SUSPENDED->value => 'Suspended',
            self::CLOSED->value => 'Closed',
        ];
    }
}
