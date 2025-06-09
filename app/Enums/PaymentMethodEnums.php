<?php

namespace App\Enums;

enum PaymentMethodEnums: string
{
    case CASH = 'cash';
    case EFT = 'eft';
    case DEPOSIT = 'deposit';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return [
            self::CASH->value => 'Cash',
            self::EFT->value => 'EFT',
            self::DEPOSIT->value => 'Deposit',
        ];
    }

    public function label(): string
    {
        return self::labels()[$this->value] ?? 'Unknown';
    }
}