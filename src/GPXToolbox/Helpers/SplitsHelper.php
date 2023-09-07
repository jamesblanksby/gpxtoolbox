<?php

namespace GPXToolbox\Helpers;

use GPXToolbox\GPXToolbox;
use GPXToolbox\Models\Split;
use GPXToolbox\Types\Point;

class SplitsHelper
{
    /**
     * @param array<Point> $points
     * @param integer|null $interval
     * @return array<Split>
     */
    public static function calculateSplits(array $points, ?int $interval = null): array
    {
        $splits = [];

        if (!$interval) {
            $interval = Split::DISTANCE_1KM;
        }

        $length = count($points);
        $lastPoint = $points[0];

        $distance = 0.0;
        $splitPoints = [];

        for ($i = 0; $i < $length; $i++) {
            $point = $points[$i];

            array_push($splitPoints, $point);

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

            if ($distance >= $interval) {
                $split = new Split($splitPoints);
                array_push($splits, $split);

                $distance = 0.0;
                $splitPoints = [];
            }
        }

        $split = new Split($splitPoints);
        array_push($splits, $split);

        return $splits;
    }
}
