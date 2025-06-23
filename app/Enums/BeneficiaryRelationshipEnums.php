<?php

namespace App\Enums;

enum BeneficiaryRelationshipEnums: string
{
    case Item = 'item';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return [
            self::Item->value => 'Item',
        ];
    }

    public function label(): string
    {
        return self::labels()[$this->value] ?? 'Unknown';
    }
}
