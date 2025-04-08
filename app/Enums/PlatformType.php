<?php

namespace App\Enums;

enum PlatformType: string
{
    case Online = 'online';
    case GOOGLE_MEET = 'Google Meet';
    case TEAMS = 'Teams';
    case ZOOM = 'Zoom';
    case OTHER = 'Other';
    case NULL = 'null';
}