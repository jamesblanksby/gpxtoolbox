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
     * @var float Average speed during the activity.
     */
    public float $averageSpeed = 0.0;

    /**
     * @var float Maximum speed during the activity.
     */
    public float $maxSpeed = 0.0;

    /**
     * @var float Average pace during the activity.
     */
    public float $averagePace = 0.0;

    /**
     * @var float Best pace during the activity.
     */
    public float $bestPace = 0.0;

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
}
