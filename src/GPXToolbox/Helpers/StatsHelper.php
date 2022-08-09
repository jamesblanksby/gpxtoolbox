<?php

namespace GPXToolbox\Helpers;

use GPXToolbox\Types\Point;
use GPXToolbox\Models\Stats;
use GPXToolbox\GPXToolbox;

class StatsHelper
{
    /**
     * Calculate statistics from a list of points.
     * @param Point[] $points
     * @return Stats
     */
    public static function calculateStats(array $points): Stats
    {
        $stats = new Stats();

        $length = count($points);
        $firstPoint = $points[0];
        $lastPoint = $points[($length - 1)];

        $stats->distance = self::calculateDistance($points);
        if (($firstPoint->time instanceof \DateTime) && ($lastPoint->time instanceof \DateTime)) {
            $stats->totalDuration = ($lastPoint->time->getTimestamp() - $firstPoint->time->getTimestamp());
        }
        $stats->movingDuration = self::calculateMovingDuration($points);
        $stats->minElevation = min(array_column($points, 'ele'));
        $stats->maxElevation = max(array_column($points, 'ele'));
        list($stats->elevationGain, $stats->elevationLoss) = self::calculateElevationGainLoss($points);
        if ($stats->distance !== 0) {
            $stats->averagePace = ($stats->movingDuration / ($stats->distance / 1000));
        }
        if ($stats->movingDuration !== 0) {
            $stats->averageSpeed = (($stats->distance / 1000) / ($stats->movingDuration / 3600));
        }

        return $stats;
    }

    /**
     * Calculate distance between a list of points.
     * @param Point[] $points
     * @return float
     */
    public static function calculateDistance(array $points): float
    {
        $distance = 0.0;

        $length = count($points);
        $lastPoint = null;

        for ($i = 0; $i < $length; $i++) {
            $point = $points[$i];

            if ($i === 0) {
                $lastPoint = $point;
                continue;
            }

            $difference = DistanceHelper::getDistance($lastPoint, $point);

            if (GPXToolbox::$DISTANCE_THRESHOLD !== false) {
                if ($difference > GPXToolbox::$DISTANCE_THRESHOLD) {
                    $distance += $difference;
                    $lastPoint = $point;
                }
            } else {
                $distance += $difference;
                $lastPoint = $point;
            }
        }

        return $distance;
    }

    /**
     * Calculate time spent moving.
     * @param Point[] $points
     * @return integer
     */
    public static function calculateMovingDuration(array $points): int
    {
        $duration = 0;

        $length = count($points);
        $lastPoint = null;

        for ($i = 0; $i < $length; $i++) {
            $point = $points[$i];

            if ($i === 0) {
                $lastPoint = $point;
                continue;
            }

            if (!($point->time instanceof \DateTime) && !($lastPoint->time instanceof \DateTime)) {
                continue;
            }

            $distanceDifference = DistanceHelper::getDistance($lastPoint, $point);
            $durationDifference = ($point->time->getTimestamp() - $lastPoint->time->getTimestamp());

            if ($distanceDifference > GPXToolbox::$MOVING_DISTANCE_THRESHOLD && $durationDifference < GPXToolbox::$MOVING_DURATION_THRESHOLD) {
                $duration += $durationDifference;
            }

            $lastPoint = $point;
        }

        return $duration;
    }

    /**
     * Calculate cumulative elevation gain/loss
     * @param Point[] $points
     * @return array
     */
    public static function calculateElevationGainLoss(array $points): array
    {
        $elevationGain = 0.0;
        $elevationLoss = 0.0;

        $length = count($points);
        $lastPoint = null;

        for ($i = 0; $i < $length; $i++) {
            $point = $points[$i];

            if ($i === 0) {
                $lastPoint = $point;
                continue;
            }

            $difference = ($point->ele - $lastPoint->ele);

            if (GPXToolbox::$ELEVATION_THRESHOLD !== false) {
                if (abs($difference) > GPXToolbox::$ELEVATION_THRESHOLD) {
                    $elevationGain += $difference > 0 ? $difference : 0;
                    $elevationLoss += $difference < 0 ? abs($difference) : 0;

                    $lastPoint = $point;
                }
            } else {
                $elevationGain += $difference > 0 ? $difference : 0;
                $elevationLoss += $difference < 0 ? abs($difference) : 0;

                $lastPoint = $point;
            }
        }

        return [$elevationGain, $elevationLoss,];
    }
}
