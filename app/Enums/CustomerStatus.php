<?php

namespace App\Enums;


enum CustomerStatus: string
{
    case Active = 'active';
    case Disabled = 'disabled';

    public static function getStatuses()
{
    return [
        self::Active, self::Disabled
    ];
}

}

