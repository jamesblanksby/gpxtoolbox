<?php

namespace GPXToolbox\Traits\Gpx;

use GPXToolbox\GPXToolbox;
use GPXToolbox\Helpers\Gpx\PointHelper;
use GPXToolbox\Models\Analytics\Statistics;
use GPXToolbox\Models\Gpx\PointCollection;

trait HasStatistics
{
    /**
     * Get statistics for the model.
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
     * Get the distance from points.
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

        foreach ($points->all() as $point) {
            $difference = PointHelper::get3dDistance($prevPoint, $point);

            $isDistanceWithinThreshold = ($difference > $distanceThreshold);

            if ($isDistanceWithinThreshold) {
                $distance += $difference;
                $prevPoint = $point;
            }
        }

        $distance = round($distance, $configuration->getDistancePrecision());

        return [$distance,];
    }

    /**
     * Get the duration from points.
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
        $movingDistanceThreshold = $configuration->getMovingDistanceThreshold();
        $movingDurationThreshold = $configuration->getMovingDurationThreshold();

        foreach ($points->all() as $point) {
            $distanceDifference = PointHelper::get3dDistance($prevPoint, $point);
            $durationDifference = abs(($prevPoint->time->getTimestamp() - $point->time->getTimestamp()));

            $isDistanceWithinThreshold = ($distanceDifference > $movingDistanceThreshold);
            $isDurationWithinThreshold = ($durationDifference < $movingDurationThreshold);

            if ($isDistanceWithinThreshold && $isDurationWithinThreshold) {
                $moving += $durationDifference;
            }

            $prevPoint = $point;
        }

        return [$moving, $total,];
    }

    /**
     * Get the elevation from points.
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

        foreach ($points->all() as $point) {
            $difference = ($prevPoint->getElevation() - $point->getElevation());

            $isDistanceWithinThreshold = (abs($difference) > $elevationThreshold);

            if ($isDistanceWithinThreshold) {
                $gain += $difference > 0 ? $difference : 0;
                $loss += $difference < 0 ? abs($difference) : 0;
                $prevPoint = $point;
            }
        }

        return [$min, $max, $gain, $loss,];
    }

    /**
     * Get the average pace and speed from statistics.
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

        if ($movingDuration) {
            $pace = ($movingDuration / ($distance / 1000));
            $speed = (($distance / 1000) / ($movingDuration / 3600));
        }

        $configuration = GPXToolbox::getConfiguration();

        $pace = round($pace, $configuration->getPacePrecision());
        $speed = round($speed, $configuration->getSpeedPrecision());

        return [$pace, $speed,];
    }
}
