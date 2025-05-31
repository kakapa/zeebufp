<?php

namespace App\Enums;

enum AreaTypeEnums: string
{
    case VILLAGE = 'village';
    case TOWN = 'town';
    case TOWNSHIP = 'township';
    case SUBURB = 'suburb';
    case CITY = 'city';
    case PROVINCE = 'province';
    case MUNICIPALITY = 'municipality';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return [
            self::VILLAGE->value => 'Village',
            self::TOWNSHIP->value => 'Township',
            self::TOWN->value => 'Town',
            self::SUBURB->value => 'Suburb',
            self::CITY->value => 'City',
            self::PROVINCE->value => 'Province',
            self::MUNICIPALITY->value => 'Municipality'
        ];
    }
}
