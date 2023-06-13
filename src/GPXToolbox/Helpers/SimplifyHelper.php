<?php

namespace GPXToolbox\Helpers;

use GPXToolbox\Types\Point;

class SimplifyHelper
{
    /**
     * Basic distance based simplification.
     * @param array<Point> $points
     * @param float $toleranceSq
     * @return array<Point>
     */
    public static function simplifyDistance(array $points, float $toleranceSq): array
    {
        $length = count($points);
        $prevPoint = $points[0];
        $newPoints = [$prevPoint,];

        for ($i = 1; $i < $length; $i++) {
            $point = $points[$i];

            if (DistanceHelper::getSquareDistance($point, $prevPoint) > $toleranceSq) {
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
     * @param array<Point> $points
     * @param float $toleranceSq
     * @return array<Point>
     */
    public static function simplifyDouglasPeucker(array $points, float $toleranceSq): array
    {
        $length = count($points);
        $first = 0;
        $last = ($length - 1);

        $firstStack = [];
        $lastStack = [];

        $newPoints  = [];

        while ($last) {
            $maxSquareDistance = 0;

            for ($i = ($first + 1); $i < $last; $i++) {
                $squareDistance = DistanceHelper::getSquareSegmentDistance($points[$i], $points[$first], $points[$last]);

                if ($squareDistance > $maxSquareDistance) {
                    $index = $i;
                    $maxSquareDistance = $squareDistance;
                }
            }

            if ($maxSquareDistance > $toleranceSq) {
                $firstStack []= $first;
                $lastStack []= $index;

                $firstStack []= $index;
                $lastStack []= $last;
            }

            $first = array_pop($firstStack);
            $last = array_pop($lastStack);
        }

        for ($i = 0; $i < $length; $i++) {
            $newPoints []= $points[$i];
        }

        return $newPoints;
    }
}
