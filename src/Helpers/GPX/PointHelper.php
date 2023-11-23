<?php

namespace GPXToolbox\Helpers\GPX;

use GPXToolbox\Models\GPX\Point;
use GPXToolbox\Models\GPX\PointCollection;

class PointHelper
{
    /**
     * The Earth's radius in meters.
     */
    public const EARTH_RADIUS = 6371000;

    /**
     * Get the 2D (planar) distance between two points on the Earth's surface.
     *
     * @param Point $a
     * @param Point $b
     *
     * @return float
     */
    public static function get2dDistance(Point $a, Point $b): float
    {
        $dx = deg2rad(($b->getLatitude() - $a->getLatitude()));
        $dy = deg2rad(($b->getLongitude() - $a->getLongitude()));

        $r = (sin(($dx / 2)) * sin(($dx / 2)) + cos(deg2rad($a->getLatitude())) * cos(deg2rad($b->getLatitude())) * sin(($dy / 2)) * sin(($dy / 2)));
        $c = (2 * atan2(sqrt($r), sqrt((1 - $r))));

        return (self::EARTH_RADIUS * $c);
    }

    /**
     * Get the 3D distance between two points, accounting for elevation.
     *
     * @param Point $a
     * @param Point $b
     *
     * @return float
     */
    public static function get3dDistance(Point $a, Point $b): float
    {
        $planar = self::get2dDistance($a, $b);
        $height = abs(($b->getElevation() - $a->getElevation()));

        return sqrt((pow($planar, 2) + pow($height, 2)));
    }

    /**
     * Calculate the squared distance between two points.
     *
     * @param Point $a
     * @param Point $b
     * @return float
     */
    public static function getSquaredDistance(Point $a, Point $b): float
    {
        $dx = ($a->getLatitude() - $b->getLatitude());
        $dy = ($a->getLongitude() - $b->getLongitude());

        return (($dx * $dx) + ($dy * $dy));
    }

    /**
     * Calculate the squared perpendicular distance from a point to a line segment.
     *
     * @param Point $a
     * @param Point $b
     * @param Point $c
     * @return float
     */
    public static function getPerpendicularSquaredDistance(Point $a, Point $b, Point $c): float
    {
        $lineLengthSq = self::getSquaredDistance($b, $c);

        if ($lineLengthSq === 0.0) {
            return self::getSquaredDistance($a, $b);
        }

        $dx = (($a->getLatitude() - $b->getLatitude()) * ($c->getLatitude() - $b->getLatitude()));
        $dy = (($a->getLongitude() - $b->getLongitude()) * ($c->getLongitude() - $b->getLongitude()));

        $t = (($dx + $dy) / $lineLengthSq);

        if ($t < 0) {
            return self::getSquaredDistance($a, $b);
        } elseif ($t > 1) {
            return self::getSquaredDistance($a, $c);
        }

        $latitude = ($b->getLatitude() + ($t * ($c->getLatitude() - $b->getLatitude())));
        $longitude = ($b->getLongitude() + ($t * ($c->getLongitude() - $b->getLongitude())));

        $d = new Point(Point::WAYPOINT, [
            'lat' => $latitude,
            'lon' => $longitude,
        ]);

        return self::getSquaredDistance($a, $d);
    }

    /**
     * Simplify a list of points using a specified tolerance.
     *
     * @param PointCollection $points
     * @param float $tolerance
     * @param bool  $highestQuality
     *
     * @return PointCollection
     */
    public static function simplify(PointCollection $points, float $tolerance = 1.0, bool $highestQuality = false): PointCollection
    {
        $toleranceSq = ($tolerance * $tolerance);

        $simplifiedPoints = $highestQuality ? $points : self::simplifyDistance($points, $toleranceSq);
        $simplifiedPoints = self::simplifyDouglasPeucker($points, $toleranceSq);

        return $simplifiedPoints;
    }

    /**
     * Simplify a list of points based on distance.
     *
     * @param PointCollection $points
     * @param float $toleranceSq
     * @return PointCollection
     */
    public static function simplifyDistance(PointCollection $points, float $toleranceSq): PointCollection
    {
        $simplifiedPoints = new PointCollection();
        $simplifiedPoints->add($points->first());

        $count = (count($points) - 1);

        for ($a = 1; $a < $count; $a++) {
            $point = $points->get($a);

            $distanceSq = self::getSquaredDistance($points->get(($a - 1)), $point);

            if ($distanceSq >= $toleranceSq) {
                $simplifiedPoints->add($point);
            }
        }

        $simplifiedPoints->add($points->last());

        return $simplifiedPoints;
    }

    /**
     * Simplify a list of points using the Douglas-Peucker algorithm.
     *
     * @param PointCollection $points
     * @param float $toleranceSq
     * @return PointCollection
     */
    public static function simplifyDouglasPeucker(PointCollection $points, float $toleranceSq): PointCollection
    {
        if ($points->count() <= 2) {
            return $points;
        }

        $firstPoint = $points->first();
        $maxDistanceSq = 0;
        $maxIndex = 0;

        $count = (count($points) - 1);

        for ($a = 1; $a < $count; $a++) {
            $distanceSq = self::getPerpendicularSquaredDistance($points->get($a), $firstPoint, $points->get($count));

            if ($distanceSq > $maxDistanceSq) {
                $maxDistanceSq = $distanceSq;
                $maxIndex = $a;
            }
        }

        $simplifiedPoints = new PointCollection();

        if ($maxDistanceSq > $toleranceSq) {
            $simplifiedPoints = self::simplifyDouglasPeucker($points->slice(0, ($maxIndex + 1)), $toleranceSq)->merge(
                self::simplifyDouglasPeucker($points->slice($maxIndex, ($count - ($maxIndex + 1))), $toleranceSq)
            );
        } else {
            $simplifiedPoints->add($firstPoint)->add($points->get($count));
        }

        return $simplifiedPoints;
    }
}
