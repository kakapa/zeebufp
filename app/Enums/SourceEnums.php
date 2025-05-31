<?php

namespace App\Enums;

enum SourceEnums: string
{
    case FRIEND = 'friend';
    case FAMILY = 'family';
    case COMMUNITY_MEETING = 'community_meeting';
    case STREET_COMMITTEE = 'street_committee';
    case SOCIAL_MEDIA = 'social_media';
    case POSTER = 'poster';
    case RADIO = 'radio';
    case VOLUNTEER_OUTREACH = 'volunteer_outreach';
    case SCHOOL_CAMPAIGN = 'school_campaign';
    case CAMPUS_CAMPAIGN = 'campus_campaign';
    case LOCAL_EVENT = 'local_event';
    case CHURCH = 'church';
    case DOOR_TO_DOOR = 'door_to_door';
    case WHATSAPP_GROUP = 'whatsapp_group';
    case YOUTH_PROGRAM = 'youth_program';
    case OTHER = 'other';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return [
            self::FRIEND->value => 'Friend',
            self::FAMILY->value => 'Family',
            self::COMMUNITY_MEETING->value => 'Community Meeting',
            self::STREET_COMMITTEE->value => 'Street Committee',
            self::SOCIAL_MEDIA->value => 'Social Media',
            self::POSTER->value => 'Poster / Pamphlet',
            self::RADIO->value => 'Radio',
            self::VOLUNTEER_OUTREACH->value => 'Volunteer Outreach',
            self::SCHOOL_CAMPAIGN->value => 'School Campaign',
            self::CAMPUS_CAMPAIGN->value => 'Campus Campaign',
            self::LOCAL_EVENT->value => 'Local Event',
            self::CHURCH->value => 'Church / Faith Group',
            self::DOOR_TO_DOOR->value => 'Door-to-Door Outreach',
            self::WHATSAPP_GROUP->value => 'WhatsApp Group',
            self::YOUTH_PROGRAM->value => 'Youth Program',
            self::OTHER->value => 'Other',
        ];
    }
}
