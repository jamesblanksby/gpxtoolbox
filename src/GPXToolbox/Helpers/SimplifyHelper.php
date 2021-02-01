<?php

namespace GPXToolbox\Helpers;

use GPXToolbox\Types\Point;

class SimplifyHelper
{
    /**
     * Basic distance based simplification.
     * @param Point[] $points
     * @param float $toleranceSq
     * @return Point[]
     */
    public static function radialDistance(array $points, float $toleranceSq) : array
    {
        $length = count($points);
        $prevPoint = $points[0];
        $newPoints = [$prevPoint,];

        for ($i = 1; $i < $length; $i++) {
            $point = $points[$i];
            
            if (self::getSquareDistance($point, $prevPoint) > $toleranceSq) {
                $newPoints []= $point;
                $prevPoint = $point;
            }
        }

        if ($prevPoint !== $point) {
            $newPoints []= $point;
        }

        return $newPoints;
    }

    /**
     * Optimized Douglas-Peucker simplification algorithm with recursion elimination.
     * @param Point[] $points
     * @param float $toleranceSq
     * @return Point[]
     */
    public static function simplifyDouglasPeucker(array $points, float $toleranceSq) : array
    {
        $length = count($points);
        $markers = array_fill(0, ($length - 1), null);
        $first = 0;
        $last = ($length - 1);
        
        $firstStack = [];
        $lastStack = [];
        
        $newPoints  = [];

        $markers[$first] = $markers[$last] = 1;

        while ($last) {
            $maxSquareDistance = 0;

            for ($i = ($first + 1); $i < $last; $i++) {
                $squareDistance = self::getSquareSegmentDistance($points[$i], $points[$first], $points[$last]);

                if ($squareDistance > $maxSquareDistance) {
                    $index = $i;
                    $maxSquareDistance = $squareDistance;
                }
            }

            if ($maxSquareDistance > $toleranceSq) {
                $markers[$index] = 1;
                
                $firstStack []= $first;
                $lastStack []= $index;

                $firstStack []= $index;
                $lastStack []= $last;
            }

            $first = array_pop($firstStack);
            $last = array_pop($lastStack);
        }

        for ($i = 0; $i < $length; $i++) {
            if ($markers[$i]) {
                $newPoints []= $points[$i];
            }
        }

        return $newPoints;
    }

    /**
     * Square distance between two points.
     * @param Point $a
     * @param Point $b
     * @return float
     */
    protected static function getSquareDistance(Point $a, Point $b) : float
    {
        $dx = ($a->lat - $b->lat);
        $dy = ($a->lon - $b->lon);
        
        return (($dx * $dx) + ($dy * $dy));
    }

    /**
     * Square distance from a point to a segment.
     * @param Point $a
     * @param Point $b
     * @param Point $c
     * @return float
     */
    private static function getSquareSegmentDistance(Point $a, Point $b, Point $c) : float
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
