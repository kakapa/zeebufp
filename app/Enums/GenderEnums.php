<?php

namespace App\Enums;

enum GenderEnums: string
{
    case FEMALE = 'female';
    case MALE = 'male';
    case OTHER = 'other';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return [
            self::FEMALE->value => 'Female',
            self::MALE->value => 'Male',
            self::OTHER->value => 'Other',
        ];
    }
}
