<?php

namespace GPXToolbox\Models;

class Stats
{
    /**
     * Distance in meters.
     * @var float
     */
    public $distance = 0.0;

    /**
     * Time spend moving in seconds.
     * @var integer
     */
    public $movingDuration = 0;

    /**
     * Total time elapsed in seconds.
     * @var integer
     */
    public $totalDuration = 0;

    /**
     * Minimum elevation in meters.
     * @var float
     */
    public $minElevation = INF;

    /**
     * Maximium elevation in meters.
     * @var float
     */
    public $maxElevation = 0.0;

    /**
     * Elevation gain in meters.
     * @var float
     */
    public $gainElevation = 0.0;

    /**
     * Elevation loss in meters.
     * @var float
     */
    public $lossElevation = 0.0;

    /**
     * Average moving pace in minutes per kilometer.
     * @var float
     */
    public $averagePace = 0.0;

    /**
     * Average speed in kilometers per hour.
     * @var float
     */
    public $averageSpeed = 0.0;

    /**
     * Array representation of stats data.
     * @return array
     */
    public function toArray(): array
    {
        return [
            'distance'       => $this->distance,
            'movingDuration' => $this->movingDuration,
            'totalDuration'  => $this->totalDuration,
            'minElevation'   => $this->minElevation,
            'maxElevation'   => $this->maxElevation,
            'gainElevation'  => $this->gainElevation,
            'lossElevation'  => $this->lossElevation,
            'averagePace'    => $this->averagePace,
            'averageSpeed'   => $this->averageSpeed,
        ];
    }
}
