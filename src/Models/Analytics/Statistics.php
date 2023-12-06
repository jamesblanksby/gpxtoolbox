<?php

namespace GPXToolbox\Models\Analytics;

use GPXToolbox\Abstracts\Model;

final class Statistics extends Model
{
    /**
     * @var float The total distance covered in kilometers.
     */
    public $distance = 0.0;

    /**
     * @var int The moving duration in seconds.
     */
    public $movingDuration = 0;

    /**
     * @var int The total duration in seconds.
     */
    public $totalDuration = 0;

    /**
     * @var float The minimum elevation reached.
     */
    public $minElevation = 0.0;

    /**
     * @var float The maximum elevation reached.
     */
    public $maxElevation = 0.0;

    /**
     * @var float The total elevation gain during the activity.
     */
    public $gainElevation = 0.0;

    /**
     * @var float The total elevation loss during the activity.
     */
    public $lossElevation = 0.0;

    /**
     * @var float The average pace in seconds per kilometer.
     */
    public $averagePace = 0.0;

    /**
     * @var float The average speed in meters per second.
     */
    public $averageSpeed = 0.0;

    /**
     * Get the total distance covered in kilometers.
     *
     * @return float
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Get the moving duration in seconds.
     *
     * @return int
     */
    public function getMovingDuration()
    {
        return $this->movingDuration;
    }

    /**
     * Get the total duration in seconds.
     *
     * @return int
     */
    public function getTotalDuration()
    {
        return $this->totalDuration;
    }

    /**
     * Get the minimum elevation reached.
     *
     * @return float
     */
    public function getMinElevation()
    {
        return $this->minElevation;
    }

    /**
     * Get the maximum elevation reached.
     *
     * @return float
     */
    public function getMaxElevation()
    {
        return $this->maxElevation;
    }

    /**
     * Get the total elevation gain during the activity.
     *
     * @return float
     */
    public function getGainElevation()
    {
        return $this->gainElevation;
    }

    /**
     * Get the total elevation loss during the activity.
     *
     * @return float
     */
    public function getLossElevation()
    {
        return $this->lossElevation;
    }

    /**
     * Get the average pace in seconds per kilometer.
     *
     * @return float
     */
    public function getAveragePace()
    {
        return $this->averagePace;
    }

    /**
     * Get the average speed in meters per second.
     *
     * @return float
     */
    public function getAverageSpeed()
    {
        return $this->averageSpeed;
    }
}
