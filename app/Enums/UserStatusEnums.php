<?php

namespace App\Enums;

enum UserStatusEnums: string
{
    case ACTIVE = 'active';
    case BLOCKED = 'blocked';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return [
            self::ACTIVE->value => 'Active',
            self::BLOCKED->value => 'Blocked'
        ];
    }
}
