<?php

namespace App\Enums;

enum PaymentStatusEnums: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case PAID = 'paid';
    case REVERSED = 'reversed';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return [
            self::PENDING->value => 'Pending',
            self::PROCESSING->value => 'Processing',
            self::PAID->value => 'Paid',
            self::REVERSED->value => 'Reserved',
        ];
    }

    public function label(): string
    {
        return self::labels()[$this->value] ?? 'Unknown';
    }
}