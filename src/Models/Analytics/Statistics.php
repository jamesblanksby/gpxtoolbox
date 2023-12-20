<?php

namespace GPXToolbox\Models\Analytics;

use GPXToolbox\Abstracts\Model;

class Statistics extends Model
{
    /**
     * @var float Distance covered in the activity.
     */
    public float $distance = 0.0;

    /**
     * @var int Duration of movement during the activity.
     */
    public int $movingDuration = 0;

    /**
     * @var int Total duration of the activity.
     */
    public int $totalDuration = 0;

    /**
     * @var float Minimum elevation during the activity.
     */
    public float $minElevation = 0.0;

    /**
     * @var float Maximum elevation during the activity.
     */
    public float $maxElevation = 0.0;

    /**
     * @var float Elevation gain during the activity.
     */
    public float $gainElevation = 0.0;

    /**
     * @var float Elevation loss during the activity.
     */
    public float $lossElevation = 0.0;

    /**
     * @var float Average pace during the activity.
     */
    public float $averagePace = 0.0;

    /**
     * @var float Average speed during the activity.
     */
    public float $averageSpeed = 0.0;

    /**
     * Get the distance covered in the activity.
     *
     * @return float
     */
    public function getDistance(): float
    {
        return $this->distance;
    }

    /**
     * Get the duration of movement during the activity.
     *
     * @return int
     */
    public function getMovingDuration(): int
    {
        return $this->movingDuration;
    }

    /**
     * Get the total duration of the activity.
     *
     * @return int
     */
    public function getTotalDuration(): int
    {
        return $this->totalDuration;
    }

    /**
     * Get the minimum elevation during the activity.
     *
     * @return float
     */
    public function getMinElevation(): float
    {
        return $this->minElevation;
    }

    /**
     * Get the maximum elevation during the activity.
     *
     * @return float
     */
    public function getMaxElevation(): float
    {
        return $this->maxElevation;
    }

    /**
     * Get the elevation gain during the activity.
     *
     * @return float
     */
    public function getGainElevation(): float
    {
        return $this->gainElevation;
    }

    /**
     * Get the elevation loss during the activity.
     *
     * @return float
     */
    public function getLossElevation(): float
    {
        return $this->lossElevation;
    }

    /**
     * Get the average pace during the activity.
     *
     * @return float
     */
    public function getAveragePace(): float
    {
        return $this->averagePace;
    }

    /**
     * Get the average speed during the activity.
     *
     * @return float
     */
    public function getAverageSpeed(): float
    {
        return $this->averageSpeed;
    }
}
