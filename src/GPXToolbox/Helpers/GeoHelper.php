<?php

namespace GPXToolbox\Helpers;

use GPXToolbox\Types\Point;

class GeoHelper
{
    /**
     * Calculate bounds based on a list of points.
     * @param array<Point> $points
     * @return array<mixed>
     */
    public static function getBounds(array $points): array
    {
        $longitudes = [];
        $latitudes = [];

        foreach ($points as $point) {
            $longitudes []= $point->lon;
            $latitudes []= $point->lat;
        }

        $minLon = min($longitudes);
        $minLat = min($latitudes);
        $maxLon = max($longitudes);
        $maxLat = max($latitudes);

        $bounds = [[$minLon, $minLat,], [$maxLon, $maxLat,],];

        return $bounds;
    }
}
