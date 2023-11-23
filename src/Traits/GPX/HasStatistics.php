<?php

namespace GPXToolbox\Traits\GPX;

use GPXToolbox\GPXToolbox;
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

        list($distance) = $this->getDistance($points);
        list($movingDuration, $totalDuration) = $this->getDuration($points);
        list($minElevation, $maxElevation, $gainElevation, $lossElevation) = $this->getElevation($points);

        $properties = compact(
            'distance',
            'movingDuration',
            'totalDuration',
            'minElevation',
            'maxElevation',
            'gainElevation',
            'lossElevation',
        );

        $statistics = new Statistics($properties);

        list($averagePace, $averageSpeed) = $this->getAverage($statistics);

        $properties = compact(
            'averagePace',
            'averageSpeed',
        );

        $statistics->fill($properties);

        return $statistics;
    }

    /**
     * Get distance data from a list of points.
     *
     * @param PointCollection $points
     * @return array
     */
    protected function getDistance(PointCollection $points): array
    {
        $prevPoint = $points->first();

        $distance = 0.0;

        $configuration = GPXToolbox::getConfiguration();
        $distanceThreshold = $configuration->getDistanceThreshold();

        for ($a = 0; $a < $points->count(); $a++) {
            if ($a === 0) {
                continue;
            }

            $point = $points->get($a);

            $difference = PointHelper::get3dDistance($prevPoint, $point);

            $isDistanceWithinThreshold = (!$distanceThreshold || $difference > $distanceThreshold);

            if ($isDistanceWithinThreshold) {
                $distance += $difference;
                $prevPoint = $point;
            }
        }

        $distance = round($distance, $configuration->getDistancePrecision());

        return [$distance,];
    }

    /**
     * Get duration data from a list of points.
     *
     * @param PointCollection $points
     * @return array
     */
    protected function getDuration(PointCollection $points): array
    {
        $firstPoint = $points->first();
        $lastPoint = $points->last();
        $prevPoint = $firstPoint;

        $moving = 0;
        $total = ($lastPoint->time->getTimestamp() - $firstPoint->time->getTimestamp());

        $configuration = GPXToolbox::getConfiguration();
        $distanceThreshold = $configuration->getDistanceThreshold();
        $movingDurationThreshold = $configuration->getMovingDurationThreshold();

        for ($a = 0; $a < $points->count(); $a++) {
            if ($a === 0) {
                continue;
            }

            $point = $points->get($a);

            $distanceDifference = PointHelper::get3dDistance($prevPoint, $point);
            $durationDifference = abs(($prevPoint->time->getTimestamp() - $point->time->getTimestamp()));

            $isDistanceWithinThreshold = (!$distanceThreshold || $distanceDifference > $distanceThreshold);
            $isDurationWithinThreshold = (!$movingDurationThreshold || $durationDifference < $movingDurationThreshold);

            if ($isDistanceWithinThreshold && $isDurationWithinThreshold) {
                $moving += $durationDifference;
            }

            $prevPoint = $point;
        }

        return [$moving, $total,];
    }

    /**
     * Get elevation data from a list of points.
     *
     * @param PointCollection $points
     * @return array
     */
    protected function getElevation(PointCollection $points): array
    {
        $prevPoint = $points->first();

        $elevationArray = array_map(function ($point) {
            return $point->getElevation();
        }, $points->all());

        $min = min($elevationArray);
        $max = max($elevationArray);
        $gain = 0.0;
        $loss = 0.0;

        $elevationThreshold = GPXToolbox::getConfiguration()->getElevationThreshold();

        for ($a = 0; $a < $points->count(); $a++) {
            if ($a === 0) {
                continue;
            }

            $point = $points->get($a);

            $difference = ($prevPoint->getElevation() - $point->getElevation());

            $isDistanceWithinThreshold = (!$elevationThreshold || abs($difference) > $elevationThreshold);

            if ($isDistanceWithinThreshold) {
                $gain += $difference > 0 ? $difference : 0;
                $loss += $difference < 0 ? abs($difference) : 0;
                $prevPoint = $point;
            }
        }

        return [$min, $max, $gain, $loss,];
    }

    /**
     * Calculate the average values based on the provided statistics.
     *
     * @param Statistics $statistics
     * @return array
     */
    protected function getAverage(Statistics $statistics): array
    {
        $pace = 0.0;
        $speed = 0.0;

        $distance = $statistics->getDistance();
        $movingDuration = $statistics->getMovingDuration();

        $pace = ($movingDuration / ($distance / 1000));
        $speed = (($distance / 1000) / ($movingDuration / 3600));

        $configuration = GPXToolbox::getConfiguration();

        $pace = round($pace, $configuration->getPacePrecision());
        $speed = round($speed, $configuration->getSpeedPrecision());

        return [$pace, $speed,];
    }
}
