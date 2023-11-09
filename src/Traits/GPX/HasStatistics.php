<?php

namespace GPXToolbox\Traits\GPX;

use GPXToolbox\Helpers\GPX\PointHelper;
use GPXToolbox\Models\Analytics\Statistics;
use GPXToolbox\Models\GPX\PointCollection;

trait HasStatistics
{
    /**
     * Get statistics for a list of points.
     *
     * @return Statistics
     */
    public function getStatistics(): Statistics
    {
        $points = $this->getPoints();

        list($distance) = self::getDistance($points);
        list($movingDuration, $totalDuration) = self::getDuration($points);
        list($minElevation, $maxElevation, $gainElevation, $lossElevation) = self::getElevation($points);

        // @TODO averagePace
        // @TODO averageSpeed

        $properties = compact(
            'distance',
            'movingDuration',
            'totalDuration',
            'minElevation',
            'maxElevation',
            'gainElevation',
            'lossElevation',
        );

        return new Statistics($properties);
    }

    /**
     * Get distance data from a list of points.
     *
     * @param PointCollection $points
     * @return array<float>
     */
    protected static function getDistance(PointCollection $points): array
    {
        $distance = 0.0;

        for ($a = 0; $a < $points->count(); $a++) {
            if ($a === 0) {
                continue;
            }

            $difference = PointHelper::get3dDistance($points->get($a), $points->get(($a - 1)));

            // @TODO validate distance threshold

            $distance += $difference;
        }

        return [$distance,];
    }

    /**
     * Get duration data from a list of points.
     *
     * @param PointCollection $points
     * @return array<int>
     */
    public static function getDuration(PointCollection $points): array
    {
        $firstPoint = $points->first();
        $lastPoint = $points->last();

        $moving = 0;
        $total = ($lastPoint->time->getTimestamp() - $firstPoint->time->getTimestamp());

        for ($a = 0; $a < $points->count(); $a++) {
            if ($a === 0) {
                continue;
            }

            $difference = ($points->get($a)->time->getTimestamp() - $points->get(($a - 1))->time->getTimestamp());

            // @TODO validate movement threshold

            $moving += $difference;
        }

        return [$moving, $total,];
    }

    /**
     * Get elevation data from a list of points.
     *
     * @param PointCollection $points
     * @return array<float>
     */
    public static function getElevation(PointCollection $points): array
    {
        $elevationArray = array_map(function ($point) {
            return $point->getElevation();
        }, $points->all());

        $min = min($elevationArray);
        $max = max($elevationArray);
        $gain = 0.0;
        $loss = 0.0;

        for ($a = 0; $a < $points->count(); $a++) {
            if ($a === 0) {
                continue;
            }

            $difference = ($points->get($a)->getElevation() - $points->get(($a - 1))->getElevation());

            // @TODO validate elevation threshold

            $gain += $difference > 0 ? $difference : 0;
            $loss += $difference < 0 ? abs($difference) : 0;
        }

        return [$min, $max, $gain, $loss,];
    }
}
