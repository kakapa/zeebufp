<?php

namespace App\Enums;

enum ClientGenderEnums: string
{
    case FEMALE = 'female';
    case MALE = 'male';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return [
            self::FEMALE->value => 'Female',
            self::MALE->value => 'Male',
        ];
    }

    public function label(): string
    {
        return self::labels()[$this->value] ?? 'Unknown';
    }
}