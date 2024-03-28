<?php

namespace App\Enum\PricingCalendar;

use App\Enum\ValuesEnumInterface;

enum DayTypeEnum: string implements ValuesEnumInterface
{
    case Weekday = 'weekday';
    case Weekend = 'weekend';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
