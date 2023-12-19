<?php

namespace GPXToolbox\Models\Analytics;

use GPXToolbox\Abstracts\Model;

class Statistics extends Model
{
    public float $distance = 0.0;

    public int $movingDuration = 0;

    public int $totalDuration = 0;

    public float $minElevation = 0.0;

    public float $maxElevation = 0.0;

    public float $gainElevation = 0.0;

    public float $lossElevation = 0.0;

    public float $averagePace = 0.0;

    public float $averageSpeed = 0.0;

    public function getDistance(): float
    {
        return $this->distance;
    }

    public function getMovingDuration(): int
    {
        return $this->movingDuration;
    }

    public function getTotalDuration(): int
    {
        return $this->totalDuration;
    }

    public function getMinElevation(): float
    {
        return $this->minElevation;
    }

    public function getMaxElevation(): float
    {
        return $this->maxElevation;
    }

    public function getGainElevation(): float
    {
        return $this->gainElevation;
    }

    public function getLossElevation(): float
    {
        return $this->lossElevation;
    }

    public function getAveragePace(): float
    {
        return $this->averagePace;
    }

    public function getAverageSpeed(): float
    {
        return $this->averageSpeed;
    }
}
