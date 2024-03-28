<?php

namespace App\Enum\PricingCalendar;

use App\Enum\ValuesEnumInterface;

enum SeasonEnum: string implements ValuesEnumInterface
{
    case Summer = 'summer';
    case Winter = 'winter';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
