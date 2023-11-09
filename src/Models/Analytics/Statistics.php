<?php

namespace GPXToolbox\Models\Analytics;

use GPXToolbox\Abstracts\Model;

class Statistics extends Model
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
}
