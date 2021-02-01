<?php

namespace GPXToolbox\Helpers;

class DateTimeHelper
{
    /**
     * Format DateTime.
     * @param \DateTime $datetime
     * @param string $format
     * @param string $timezone
     * @return string
     */
    public function format(\DateTime $datetime, string $format = 'c', string $timezone = 'UTC') : string
    {
        $datetime->setTimezone(new \DateTimeZone($timezone));
        $formatted = $datetime->format($format);

        return $formatted;
    }
}
