<?php

namespace GPXToolbox\Types;

use GPXToolbox\Helpers\GeoHelper;
use GPXToolbox\Helpers\SerializationHelper;
use GPXToolbox\Helpers\SimplifyHelper;
use GPXToolbox\Helpers\StatsHelper;
use GPXToolbox\Models\Stats;
use GPXToolbox\Types\Extensions\ExtensionAbstract;

class Segment
{
    /**
     * A list of track points.
     * @var Point[]
     */
    public $points = [];

    /**
     * A list of extensions.
     * @var ExtensionAbstract[]
     */
    public $extensions = [];

    /**
     * Calculate Segment bounds.
     * @return array
     */
    public function bounds(): array
    {
        $points = $this->getPoints();
        $bounds = GeoHelper::getBounds($points);

        return $bounds;
    }

    /**
     * Calculate Segment stats.
     * @return Stats
     */
    public function stats(): Stats
    {
        $points = $this->getPoints();
        $stats = StatsHelper::calculateStats($points);

        return $stats;
    }

    /**
     * Simplify path by removing extra points with given tolerance.
     * @param float $tolerance
     * @param boolean $highestQuality
     * @return self
     */
    public function simplify(float $tolerance = 1.0, bool $highestQuality = false): self
    {
        $points = $this->getPoints();

        if (count($points) < 2) {
            return $this;
        }

        $toleranceSq = ($tolerance * $tolerance);

        $points = $highestQuality ? $points : SimplifyHelper::simplifyDistance($points, $toleranceSq);
        $points = SimplifyHelper::simplifyDouglasPeucker($points, $toleranceSq);

        $this->points = $points;

        return $this;
    }

    /**
     * Gather Segment points.
     * @return array
     */
    public function getPoints(): array
    {
        return $this->points;
    }

    /**
     * Add point to segment.
     * @param Point $trkpt
     * @return self
     */
    public function addPoint(Point $trkpt): self
    {
        array_push($this->points, $trkpt);

        return $this;
    }

    /**
     * Array representation of segment data.
     * @return array
     */
    public function toArray(): array
    {
        return [
            'points'     => SerializationHelper::toArray($this->points),
            'extensions' => SerializationHelper::toArray($this->extensions),
        ];
    }
}
