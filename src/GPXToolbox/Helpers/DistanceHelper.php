<?php

namespace GPXToolbox\Helpers;

use GPXToolbox\Types\Point;
use GPXToolbox\GPXToolbox;

class DistanceHelper
{
    /**
     * Radius of planet earch.
     * @var int
     */
    const EARTH_RADIUS = 6371000;

    /**
     * Calculate distance between two points.
     * @param Point $a
     * @param Point $b
     * @return float
     */
    public static function getDistance(Point $a, Point $b) : float
    {
        return self::get3dDistance($a, $b);
    }

    /**
     * Calculate 2d distance between two points.
     * @param Point $a
     * @param Point $b
     * @return float
     */
    public static function get2dDistance(Point $a, Point $b) : float
    {
        $dy = deg2rad(($b->lon - $a->lon));
        $dx = deg2rad(($b->lat - $a->lat));

        $r = (sin(($dx / 2)) * sin(($dx / 2)) + cos(deg2rad($a->lat)) * cos(deg2rad($b->lat)) * sin(($dy / 2)) * sin(($dy / 2)));
        $c = (2 * atan2(sqrt($r), sqrt((1 - $r))));

        return (self::EARTH_RADIUS * $c);
    }

    /**
     * Calculate 3d distance between two points.
     * @param Point $a
     * @param Point $b
     * @return float
     */
    public static function get3dDistance(Point $a, Point $b) : float
    {
        $planar = self::get2dDistance($a, $b);
        $height = abs(($b->ele - $a->ele));

        return sqrt((pow($planar, 2) + pow($height, 2)));
    }

    /**
      * Squared distance between two points.
      * @param Point $a
      * @param Point $b
      * @return float
      */
    public static function getSquareDistance(Point $a, Point $b) : float
    {
        $dx = ($a->lat - $b->lat);
        $dy = ($a->lon - $b->lon);
        
        return (($dx * $dx) + ($dy * $dy));
    }

    /**
     * Squared distance from a point to a segment.
     * @param Point $a
     * @param Point $b
     * @param Point $c
     * @return float
     */
    public static function getSquareSegmentDistance(Point $a, Point $b, Point $c) : float
    {
        $x = $b->lat;
        $y = $b->lon;

        $dx = ($c->lat - $x);
        $dy = ($c->lon - $y);
        
        if ($dx !== 0 || $dy !== 0) {
            $t = ((($a->lat - $x) * $dx + ($a->lon - $y) * $dy) / (($dx * $dx) + ($dy * $dy)));

            if ($t > 1) {
                $x = $c->lat;
                $y = $c->lon;
            } elseif ($t > 0) {
                $x += ($dx * $t);
                $y += ($dy * $t);
            }
        }

        $dx = ($a->lat - $x);
        $dy = ($a->lon - $y);
        
        return (($dx * $dx) + ($dy * $dy));
    }
}
