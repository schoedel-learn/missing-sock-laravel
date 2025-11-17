<?php

namespace App\Enums;

enum OrganizationType: string
{
    case School = 'school';
    case Preschool = 'preschool';
    case Sports = 'sports';
    case Corporate = 'corporate';
    case Event = 'event';
    case Custom = 'custom';

    public function label(): string
    {
        return match ($this) {
            self::School => 'School',
            self::Preschool => 'Preschool / Daycare',
            self::Sports => 'Sports / Team',
            self::Corporate => 'Corporate / Business',
            self::Event => 'Event / Camp',
            self::Custom => 'Custom',
        };
    }
}

