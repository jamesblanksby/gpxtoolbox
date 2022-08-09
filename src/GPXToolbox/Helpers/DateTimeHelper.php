<?php

namespace GPXToolbox\Helpers;

class DateTimeHelper
{
    /**
     * Format DateTime.
     * @param mixed $datetime
     * @param string $format
     * @param string $timezone
     * @return string|null
     */
    public static function format($datetime, string $format = 'c', string $timezone = 'UTC'): ?string
    {
        $formatted = null;

        if ($datetime instanceof \DateTime) {
            $datetime->setTimezone(new \DateTimeZone($timezone));
            $formatted = $datetime->format($format);
        }

        return $formatted;
    }
}
