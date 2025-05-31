<?php

namespace App\Enums;

enum WorkStatusEnums: string
{
    case EMPLOYED = 'employed';
    case UNEMPLOYED = 'unemployed';
    case SELFEMPLOYED = 'self_employed';
    case STUDENT = 'student';
    case RETIRED = 'retired';
    case FREELANCER = 'freelancer';
    case LOOKING = 'looking';
    case NOTLOOKING = 'not_looking';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return [
            self::EMPLOYED->value => 'Employed',
            self::UNEMPLOYED->value => 'Unemployed',
            self::SELFEMPLOYED->value => 'Self-Employed',
            self::STUDENT->value => 'Student',
            self::RETIRED->value => 'Retired',
            self::FREELANCER->value => 'Freelancer',
            self::LOOKING->value => 'Looking for Work',
            self::NOTLOOKING->value => 'Not Looking for Work',
        ];
    }
}
