<?php

namespace GPXToolbox\Helpers\Gpx;

use GPXToolbox\Models\Gpx\Point;
use GPXToolbox\Models\Gpx\PointCollection;

class PointHelper
{
    /**
     * Earth radius in meters.
     */
    public const EARTH_RADIUS = 6371000;

    /**
     * Calculate 2D distance between two points.
     *
     * @param Point $a
     * @param Point $b
     * @return float
     */
    public static function get2dDistance(Point $a, Point $b): float
    {
        $dx = deg2rad(($a->getX() - $b->getX()));
        $dy = deg2rad(($a->getY() - $b->getY()));

        $r = (sin(($dx / 2)) * sin(($dx / 2)) + cos(deg2rad($a->getX())) * cos(deg2rad($b->getX())) * sin(($dy / 2)) * sin(($dy / 2)));
        $c = (2 * atan2(sqrt($r), sqrt((1 - $r))));

        return (self::EARTH_RADIUS * $c);
    }

    /**
     * Calculate 3D distance between two points.
     *
     * @param Point $a
     * @param Point $b
     * @return float
     */
    public static function get3dDistance(Point $a, Point $b): float
    {
        $planar = self::get2dDistance($a, $b);
        $height = abs(($a->getZ() - $b->getZ()));

        return sqrt((pow($planar, 2) + pow($height, 2)));
    }

    /**
     * Calculate square of the distance between two points.
     *
     * @param Point $a
     * @param Point $b
     * @return float
     */
    public static function getSquareDistance(Point $a, Point $b): float
    {
        $dx = ($a->getX() - $b->getX());
        $dy = ($a->getY() - $b->getY());

        return (($dx * $dx) + ($dy * $dy));
    }

    /**
     * Calculate square of the distance between a line segment and a point.
     *
     * @param Point $a
     * @param Point $b
     * @param Point $c
     * @return float
     */
    public static function getSquareSegmentDistance(Point $a, Point $b, Point $c): float
    {
        $x = $b->getX();
        $y = $b->getY();

        $dx = ($c->getX() - $x);
        $dy = ($c->getY() - $y);

        $t = ((($a->getX() - $x) * $dx) + (($a->getY() - $y) * $dy)) / (($dx * $dx) + ($dy * $dy));

        if ($t > 1) {
            $x = $c->getX();
            $y = $c->getY();
        } elseif ($t > 0) {
            $x += ($dx * $t);
            $y += ($dy * $t);
        }

        $dx = ($a->getX() - $x);
        $dy = ($a->getY() - $y);

        return (($dx * $dx) + ($dy * $dy));
    }

    /**
     * Simplify a collection of points.
     *
     * @param PointCollection $points
     * @param float $tolerance
     * @param bool $highestQuality
     * @return PointCollection
     */
    public static function simplify(PointCollection $points, float $tolerance = 0.1, bool $highestQuality = true): PointCollection
    {
        $toleranceSq = ($tolerance * $tolerance);

        $simplifiedPoints = $highestQuality ? $points : self::simplifyRadialDistance($points, $toleranceSq);
        $simplifiedPoints = self::simplifyDouglasPeucker($points, $toleranceSq);

        return $simplifiedPoints;
    }

    /**
     * Simplify a collection of points using the Radial Distance algorithm.
     *
     * @param PointCollection $points
     * @param float $toleranceSq
     * @return PointCollection
     */
    public static function simplifyRadialDistance(PointCollection $points, float $toleranceSq): PointCollection
    {
        $count = $points->count();

        if ($count <= 2) {
            return $points;
        }

        $prevPoint = $points->first();

        $simplifiedPoints = new PointCollection([$prevPoint,]);

        for ($a = 1; $a < $count; $a++) {
            $point = $points->get($a);

            $distanceSq = self::getSquareDistance($prevPoint, $point);

            if ($distanceSq >= $toleranceSq) {
                $simplifiedPoints->add($point);
                $prevPoint = $point;
            }
        }

        if ($point !== $prevPoint) {
            $simplifiedPoints->add($point);
        }

        return $simplifiedPoints;
    }

    /**
     * Simplify a collection of points using the Douglas-Peucker algorithm.
     *
     * @param PointCollection $points
     * @param float $toleranceSq
     * @return PointCollection
     */
    public static function simplifyDouglasPeucker(PointCollection $points, float $toleranceSq): PointCollection
    {
        $count = $points->count();

        if ($count <= 2) {
            return $points;
        }

        $markers = array_fill(0, $count, false);
        $markers[0] = $markers[($count - 1)] = true;

        $stack = [0, ($count - 1),];

        while ($stack) {
            $last = array_pop($stack);
            $first = array_pop($stack);

            $index = null;
            $maxDistanceSq = 0;

            for ($a = ($first + 1); $a < $last; $a++) {
                $distanceSq = self::getSquareSegmentDistance(
                    $points->get($a),
                    $points->get($first),
                    $points->get($last)
                );

                if ($distanceSq > $maxDistanceSq) {
                    $index = $a;
                    $maxDistanceSq = $distanceSq;
                }
            }

            if ($maxDistanceSq > $toleranceSq) {
                $markers[$index] = true;

                array_push($stack, $first, $index, $index, $last);
            }
        }

        $simplifiedPoints = new PointCollection();

        for ($a = 0; $a < $count; $a++) {
            if ($markers[$a]) {
                $simplifiedPoints->add($points->get($a));
            }
        }

        return $simplifiedPoints;
    }
}
