<?php

namespace App\Enums;

enum ClaimStatusEnums: string
{
    case SUBMITTED = 'submitted';
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case INVESTIGATION = 'investigation';
    case APPROVED = 'approved';
    case DECLINED = 'declined';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return [
            self::SUBMITTED->value => 'Submitted',
            self::PENDING->value => 'Pending',
            self::PROCESSING->value => 'Processing',
            self::INVESTIGATION->value => 'Investigation',
            self::APPROVED->value => 'Approved',
            self::DECLINED->value => 'Declined',
        ];
    }

    public function label(): string
    {
        return self::labels()[$this->value] ?? 'Unknown';
    }
}