<?php

namespace GPXToolbox\Helpers;

use GPXToolbox\GPXToolbox;
use GPXToolbox\Models\Stats;
use GPXToolbox\Types\Point;
use DateTime;

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

        $stats->distance = round(self::calculateDistance($points), GPXToolbox::$DISTANCE_PRECISION);
        if (($firstPoint->time instanceof DateTime) && ($lastPoint->time instanceof DateTime)) {
            $stats->totalDuration = ($lastPoint->time->getTimestamp() - $firstPoint->time->getTimestamp());
        }
        $stats->movingDuration = self::calculateMovingDuration($points);
        $stats->minElevation = min(array_column($points, 'ele'));
        $stats->maxElevation = max(array_column($points, 'ele'));
        list($stats->gainElevation, $stats->lossElevation) = self::calculateElevationGainLoss($points);
        if ($stats->distance !== 0) {
            $stats->averagePace = round(($stats->movingDuration / ($stats->distance / 1000)), GPXToolbox::$PACE_PRECISION);
        }
        if ($stats->movingDuration !== 0) {
            $stats->averageSpeed = round((($stats->distance / 1000) / ($stats->movingDuration / 3600)), GPXToolbox::$SPEED_PRECISION);
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
        $lastPoint = $points[0];

        for ($i = 0; $i < $length; $i++) {
            $point = $points[$i];

            if ($i === 0) {
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
        $lastPoint = $points[0];

        for ($i = 0; $i < $length; $i++) {
            $point = $points[$i];

            if ($i === 0) {
                continue;
            }

            if (!($point->time instanceof DateTime) && !($lastPoint->time instanceof DateTime)) {
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
     * Calculate cumulative elevation gain/loss.
     * @param Point[] $points
     * @return array
     */
    public static function calculateElevationGainLoss(array $points): array
    {
        $gainElevation = 0.0;
        $lossElevation = 0.0;

        $length = count($points);
        $lastPoint = $points[0];

        for ($i = 0; $i < $length; $i++) {
            $point = $points[$i];

            if ($i === 0) {
                continue;
            }

            $difference = ($point->ele - $lastPoint->ele);

            if (GPXToolbox::$ELEVATION_THRESHOLD !== false) {
                if (abs($difference) > GPXToolbox::$ELEVATION_THRESHOLD) {
                    $gainElevation += $difference > 0 ? $difference : 0;
                    $lossElevation += $difference < 0 ? abs($difference) : 0;

                    $lastPoint = $point;
                }
            } else {
                $gainElevation += $difference > 0 ? $difference : 0;
                $lossElevation += $difference < 0 ? abs($difference) : 0;

                $lastPoint = $point;
            }
        }

        return [$gainElevation, $lossElevation,];
    }
}
