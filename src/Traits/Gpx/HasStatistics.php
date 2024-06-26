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
        list($averageSpeed, $maxSpeed) = $this->getSpeed($points);
        list($averagePace, $bestPace) = $this->getPace($points);
        list($minElevation, $maxElevation, $gainElevation, $lossElevation) = $this->getElevation($points);

        $properties = compact(
            'distance',
            'movingDuration',
            'totalDuration',
            'averageSpeed',
            'maxSpeed',
            'averagePace',
            'bestPace',
            'minElevation',
            'maxElevation',
            'gainElevation',
            'lossElevation',
        );

        return new Statistics($properties);
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
        $distanceThreshold = $configuration->distanceThreshold;

        foreach ($points->all() as $point) {
            $difference = PointHelper::get3dDistance($prevPoint, $point);

            $isDistanceWithinThreshold = ($difference > $distanceThreshold);

            if ($isDistanceWithinThreshold) {
                $distance += $difference;
                $prevPoint = $point;
            }
        }

        $distance = round($distance, $configuration->distancePrecision);

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
        $movingDistanceThreshold = $configuration->movingDistanceThreshold;
        $movingDurationThreshold = $configuration->movingDurationThreshold;

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
     * Get the speed from points.
     *
     * @param PointCollection $points
     * @return array
     */
    protected function getSpeed(PointCollection $points): array
    {
        $count = 0;
        $prevPoint = $points->first();

        $total = 0.0;
        $max = 0.0;

        foreach ($points->all() as $point) {
            $distanceDifference = PointHelper::get3dDistance($prevPoint, $point);
            $durationDifference = abs(($prevPoint->time->getTimestamp() - $point->time->getTimestamp()));

            if ($durationDifference > 0) {
                $speed = (($distanceDifference / 1000) / ($durationDifference / 3600));
                $total += $speed;

                if ($speed > $max) {
                    $max = $speed;
                }

                $count++;
            }

            $prevPoint = $point;
        }

        $average = $count > 0 ? ($total / $count) : 0.0;

        $speedPrecision = GPXToolbox::getConfiguration()->speedPrecision;

        $average = round($average, $speedPrecision);
        $max = round($max, $speedPrecision);

        return [$average, $max,];
    }

    /**
     * Get the pace from points.
     *
     * @param PointCollection $points
     * @return array
     */
    protected function getPace(PointCollection $points): array
    {
        $count = 0;
        $prevPoint = $points->first();

        $total = 0.0;
        $best = PHP_FLOAT_MAX;

        foreach ($points->all() as $point) {
            $distanceDifference = PointHelper::get3dDistance($prevPoint, $point);
            $durationDifference = abs(($prevPoint->time->getTimestamp() - $point->time->getTimestamp()));

            if ($durationDifference > 0) {
                $pace = ($durationDifference / ($distanceDifference / 1000));
                $total += $pace;

                if ($pace < $best) {
                    $best = $pace;
                }

                $count++;
            }

            $prevPoint = $point;
        }

        $average = $count > 0 ? ($total / $count) : 0.0;

        $pacePrecision = GPXToolbox::getConfiguration()->pacePrecision;

        $average = round($average, $pacePrecision);
        $best = round($best, $pacePrecision);

        return [$average, $best,];
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

        $elevationThreshold = GPXToolbox::getConfiguration()->elevationThreshold;

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
}
