<?php

namespace GPXToolbox\Types;

use GPXToolbox\Helpers\GeoHelper;
use GPXToolbox\Helpers\SerializationHelper;
use GPXToolbox\Helpers\SimplifyHelper;
use GPXToolbox\Helpers\StatsHelper;
use GPXToolbox\Interfaces\ArraySerializableInterface;
use GPXToolbox\Models\Stats;
use GPXToolbox\Types\Extensions\ExtensionAbstract;

class Segment implements ArraySerializableInterface
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
     * Add extension to segment.
     * @param ExtensionAbstract $extension
     * @return self
     */
    public function addExtension(ExtensionAbstract $extension): self
    {
        array_push($this->extensions, $extension);

        return $this;
    }

    /**
     * Gather Segment points.
     * @return Point[]
     */
    public function getPoints(): array
    {
        return $this->points;
    }

    /**
     * Calculate Segment bounds.
     * @return mixed[]
     */
    public function getBounds(): array
    {
        $points = $this->getPoints();
        $bounds = GeoHelper::getBounds($points);

        return $bounds;
    }

    /**
     * Calculate Segment stats.
     * @return Stats
     */
    public function getStats(): Stats
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
     * Array representation of segment data.
     * @return mixed[]
     */
    public function toArray(): array
    {
        return SerializationHelper::filterNotNull([
            'trkpt'      => SerializationHelper::toArray($this->points),
            'extensions' => SerializationHelper::toArray($this->extensions),
        ]);
    }
}
