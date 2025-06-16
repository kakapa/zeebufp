<?php

namespace App\Enums;

enum DocumentStatusEnums: string
{
    case DRAFT = 'draft';
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case ARCHIVED = 'archived';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return [
            self::DRAFT->value => 'Draft',
            self::PENDING->value => 'Pending',
            self::APPROVED->value => 'Approved',
            self::REJECTED->value => 'Rejected',
            self::ARCHIVED->value => 'Archived'
        ];
    }

    public function label(): string
    {
        return self::labels()[$this->value] ?? 'Unknown';
    }
}