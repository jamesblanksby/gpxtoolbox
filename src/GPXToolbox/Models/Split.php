<?php

namespace GPXToolbox\Models;

use GPXToolbox\Helpers\SerializationHelper;
use GPXToolbox\Helpers\StatsHelper;
use GPXToolbox\Interfaces\ArraySerializableInterface;
use GPXToolbox\Types\Point;

class Split implements ArraySerializableInterface
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
     * A list of split points.
     * @var array<Point>
     */
    public $points = [];

    /**
     * Split statistical data.
     * @var Stats
     */
    public $stats;

    /**
     * Split constructor.
     * @param array<Point> $points
     */
    public function __construct(array $points)
    {
        $this->points = $points;
        $this->stats = StatsHelper::calculateStats($points);
    }

    /**
     * Array representation of split data.
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return SerializationHelper::filterNotNull([
            'points' => SerializationHelper::toArray($this->points),
            'stats'  => $this->stats->toArray(),
        ]);
    }
}
