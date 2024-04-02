<?php

declare(strict_types=1);

namespace App\Helpers;

use DateTime;
use Exception;

class DateFromStringHelper
{
    /**
     * @throws Exception
     */
    public static function dateFromString(string $date): DateTime
    {
        try {
            return new DateTime($date);
        } catch (Exception) {
            throw new Exception('Invalid Date string passed in'); // Ideally we would want a custom exception class here
        }
    }
}
