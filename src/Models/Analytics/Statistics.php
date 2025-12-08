<?php

namespace GPXToolbox\Models\Analytics;

use GPXToolbox\Abstracts\Model;

class Statistics extends Model
{
    /**
     * Distance covered in the activity.
     * @var float
     */
    public float $distance = 0.0;

    /**
     * Duration of movement during the activity.
     * @var int
     */
    public int $movingDuration = 0;

    /**
     * Total duration of the activity.
     * @var int
     */
    public int $totalDuration = 0;

    /**
     * Average speed during the activity.
     * @var float
     */
    public float $averageSpeed = 0.0;

    /**
     * Maximum speed during the activity.
     * @var float
     */
    public float $maxSpeed = 0.0;

    /**
     * Average pace during the activity.
     * @var float
     */
    public float $averagePace = 0.0;

    /**
     * Best pace during the activity.
     * @var float
     */
    public float $bestPace = 0.0;

    /**
     * Minimum elevation during the activity.
     * @var float
     */
    public float $minElevation = 0.0;

    /**
     * Maximum elevation during the activity.
     * @var float
     */
    public float $maxElevation = 0.0;

    /**
     * Elevation gain during the activity.
     * @var float
     */
    public float $gainElevation = 0.0;

    /**
     * Elevation loss during the activity.
     * @var float
     */
    public float $lossElevation = 0.0;
}
