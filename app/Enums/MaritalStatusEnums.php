<?php

namespace App\Enums;

enum MaritalStatusEnums: string
{
    case SINGLE = 'single';
    case MARRIED = 'married';
    case DIVORCED = 'divorced';
    case WIDOWED = 'widowed';
    case SEPARATED = 'separated';
    case ENGAGED = 'engaged';
    case INRELATIONSHIP = 'in_relationship';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return [
            self::SINGLE->value => 'Single',
            self::MARRIED->value => 'Married',
            self::DIVORCED->value => 'Divorced',
            self::WIDOWED->value => 'Widowed',
            self::SEPARATED->value => 'Separated',
            self::ENGAGED->value => 'Engaged',
            self::INRELATIONSHIP->value => 'In a Relationship',
        ];
    }
}
