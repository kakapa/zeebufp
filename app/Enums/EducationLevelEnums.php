<?php

namespace App\Enums;

enum EducationLevelEnums: string
{
    case NONE = 'none';
    case PRIMARY = 'primary';
    case SECONDARY = 'secondary';
    case GRADE_12 = 'grade_12';
    case TVET = 'tvet';
    case DIPLOMA = 'diploma';
    case BACHELORS = 'bachelors';
    case HONOURS = 'honours';
    case MASTERS = 'masters';
    case DOCTORATE = 'doctorate';
    case OTHER = 'other';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return [
            self::NONE->value => 'No Formal Education',
            self::PRIMARY->value => 'Primary School',
            self::SECONDARY->value => 'Secondary School (Grade 8–11)',
            self::GRADE_12->value => 'Matric / Grade 12',
            self::TVET->value => 'TVET College',
            self::DIPLOMA->value => 'Diploma',
            self::BACHELORS->value => "Bachelor's Degree",
            self::HONOURS->value => "Honours Degree",
            self::MASTERS->value => "Master's Degree",
            self::DOCTORATE->value => "Doctorate / PhD",
            self::OTHER->value => 'Other',
        ];
    }
}
