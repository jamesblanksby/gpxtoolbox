<?php

namespace GPXToolbox\Parsers\Values;

use DateTime;
use DateTimeZone;

class DateTimeParser
{
    /**
     * Parses datetime string with timezone.
     * @param string $value
     * @param string $timezone
     * @return DateTime
     */
    public static function parse(string $value, string $timezone = 'UTC'): DateTime
    {
        $timezone = new DateTimeZone($timezone);
        $datetime = new DateTime($value, $timezone);
        $datetime->setTimezone(new DateTimeZone(date_default_timezone_get()));

        return $datetime;
    }
}
