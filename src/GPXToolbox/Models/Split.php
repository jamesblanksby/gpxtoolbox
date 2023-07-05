<?php

namespace GPXToolbox\Models;

use GPXToolbox\Helpers\StatsHelper;
use GPXToolbox\Types\Point;

class Split
{
    /**
     * @var int
     */
    public const DISTANCE_1KM = 1000;

    /**
     * @var int
     */
    public const DISTANCE_5KM = 5000;

    /**
     * @var float
     */
    public const DISTANCE_1MI = 1609.344;

    /**
     * @var float
     */
    public const DISTANCE_5MI = 8046.72;

    /**
     * A list of split points.
     * @var array<Point>
     */
    public $points = [];

    /**
     * Split statistical data.
     * @var Stats|null
     */
    public $stats = null;

    /**
     * Split constructor.
     * @param array<Point> $points
     */
    public function __construct(array $points)
    {
        $this->points = $points;
        $this->stats = StatsHelper::calculateStats($points);
    }
}
