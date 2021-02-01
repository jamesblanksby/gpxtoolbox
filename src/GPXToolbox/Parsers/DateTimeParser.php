<?php

namespace GPXToolbox\Parsers;

class DateTimeParser
{
    /**
     * Parses datetime string with timezone.
     * @param mixed $value
     * @param string $timezone
     * @return \DateTime
     */
    public static function parse($value, string $timezone = 'UTC') : \DateTime
    {
        $timezone = new \DateTimeZone($timezone);
        $datetime = new \DateTime($value, $timezone);
        $datetime->setTimezone(new \DateTimeZone(date_default_timezone_get()));

        return $datetime;
    }
}
