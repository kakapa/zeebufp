<?php

namespace App\Enums;

enum BeneficiaryRelationshipEnums: string
{
    case SPOUSE = 'spouse';
    case CHILD = 'child';
    case PARENT = 'parent';
    case SIBLING = 'sibling';
    case OTHER_RELATIVE = 'other_relative';
    case BUSINESS_PARTNER = 'business_partner';
    case FRIEND = 'friend';
    case OTHER = 'other';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return [
            self::SPOUSE->value => 'Spouse',
            self::CHILD->value => 'Child',
            self::PARENT->value => 'Parent',
            self::SIBLING->value => 'Sibling',
            self::OTHER_RELATIVE->value => 'Other Relative',
            self::BUSINESS_PARTNER->value => 'Business Partner',
            self::FRIEND->value => 'Friend',
            self::OTHER->value => 'Other',
        ];
    }

    public function label(): string
    {
        return self::labels()[$this->value] ?? 'Unknown';
    }

    // Optional: Group relationships by category if needed
    public static function groupedOptions(): array
    {
        return [
            'Family' => [
                self::SPOUSE->value => self::SPOUSE->label(),
                self::CHILD->value => self::CHILD->label(),
                self::PARENT->value => self::PARENT->label(),
                self::SIBLING->value => self::SIBLING->label(),
                self::OTHER_RELATIVE->value => self::OTHER_RELATIVE->label(),
            ],
            'Other Relationships' => [
                self::BUSINESS_PARTNER->value => self::BUSINESS_PARTNER->label(),
                self::FRIEND->value => self::FRIEND->label(),
                self::OTHER->value => self::OTHER->label(),
            ]
        ];
    }
}
