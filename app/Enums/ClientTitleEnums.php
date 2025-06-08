<?php

namespace App\Enums;

enum ClientTitleEnums: string
{
    case MS = 'ms';
    case MRS = 'mrs';
    case MR = 'mr';
    case DR = 'dr';
    case PROF = 'prof';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return [
            self::MS->value => 'Ms',
            self::MRS->value => 'Mrs',
            self::MR->value => 'Mr',
            self::DR->value => 'Dr',
            self::PROF->value => 'Prof',
        ];
    }

    public function label(): string
    {
        return self::labels()[$this->value] ?? 'Unknown';
    }
}