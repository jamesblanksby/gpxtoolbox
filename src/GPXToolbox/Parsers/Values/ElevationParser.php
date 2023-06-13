<?php

namespace GPXToolbox\Parsers\Values;

use GPXToolbox\GPXToolbox;

class ElevationParser
{
    /**
     * Parses elevation value.
     * @param string $value
     * @return float
     */
    public static function parse(string $value): float
    {
        return round((float) $value, GPXToolbox::$ELEVATION_PRECISION);
    }
}
