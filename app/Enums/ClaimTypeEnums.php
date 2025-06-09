<?php

namespace App\Enums;

enum ClaimTypeEnums: string
{
    case FUNERAL = 'funeral';
    case BURIAL = 'burial';
    case CREMATION = 'cremation';
    case TRANSPORTATION = 'transportation';
    case MEMORIAL = 'memorial';
    case TOMBSTONE = 'tombstone';
    case FLOWERS = 'flowers';
    case OBITUARY = 'obituary';
    case EMERGENCY = 'emergency';
    case OTHER = 'other';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return [
            self::FUNERAL->value => 'Funeral Service',
            self::BURIAL->value => 'Burial',
            self::CREMATION->value => 'Cremation',
            self::TRANSPORTATION->value => 'Transportation',
            self::MEMORIAL->value => 'Memorial Service',
            self::TOMBSTONE->value => 'Tombstone',
            self::FLOWERS->value => 'Flowers',
            self::OBITUARY->value => 'Obituary Notice',
            self::EMERGENCY->value => 'Emergency Fund',
            self::OTHER->value => 'Other Expense',
        ];
    }

    public function label(): string
    {
        return self::labels()[$this->value] ?? 'Unknown';
    }
}