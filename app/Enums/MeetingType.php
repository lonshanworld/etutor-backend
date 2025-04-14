<?php

namespace App\Enums;

enum MeetingType: string
{
    case VIRTUAL = 'Virtual';
    case INPERSON = 'In-Person';
    case HYBRID = 'Hybrid';
    
    /**
     * Get all available meeting types as array
     *
     * @return array
     */
    public static function toArray(): array
    {
        return [
            self::VIRTUAL->value => 'Virtual',
            self::INPERSON->value => 'In-Person',
            self::HYBRID->value => 'Hybrid',
        ];
    }
}
