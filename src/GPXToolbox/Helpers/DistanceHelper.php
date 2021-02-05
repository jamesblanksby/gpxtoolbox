<?php

namespace GPXToolbox\Helpers;

use GPXToolbox\Types\Point;
use GPXToolbox\GPXToolbox;

class DistanceHelper
{
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
