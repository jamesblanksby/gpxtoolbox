<?php

namespace GPXToolbox\Parsers\Values;

use GPXToolbox\GPXToolbox;

class CoordinateParser
{
    /**
     * Parses coordinate value.
     * @param string $value
     * @return float
     */
    public static function parse(string $value): float
    {
        return round((float) $value, GPXToolbox::$COORDINATE_PRECISION);
    }
}
