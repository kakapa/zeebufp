<?php

namespace App\Enums;

enum ClientSourceEnums: string
{
    case FRIEND = 'friend';
    case FAMILY = 'family';
    case COLLEAGUE = 'colleague';
    case SOCIAL_MEDIA = 'social_media';
    case TV = 'tv';
    case RADIO = 'radio';
    case NEWSPAPER = 'newspaper';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return [
            self::FRIEND->value => 'Friend',
            self::FAMILY->value => 'Family',
            self::COLLEAGUE->value => 'Colleague',
            self::SOCIAL_MEDIA->value => 'Social Media',
            self::TV->value => 'TV',
            self::RADIO->value => 'Radio',
            self::NEWSPAPER->value => 'Newspaper',
        ];
    }

    public function label(): string
    {
        return self::labels()[$this->value] ?? 'Unknown';
    }
}