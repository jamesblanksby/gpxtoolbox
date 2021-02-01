<?php

namespace GPXToolbox\Types;

use GPXToolbox\Helpers\SimplifyHelper;
use GPXToolbox\Helpers\SerializationHelper;

class Segment
{
    /**
     * A list of track points.
     * @var Point[]|null
     */
    public $points = null;

    /**
     * Simplify path by removing extra points with given tolerance.
     * @param float $tolerance
     * @param boolean $highestQuality
     * @return Segment
     */
    public function simplify(float $tolerance = 1.0, bool $highestQuality = false) : Segment
    {
        $points = $this->points;

        if (count($points) < 2) {
            return $points;
        }

        $toleranceSq = ($tolerance * $tolerance);

        $points = $highestQuality ? $points : SimplifyHelper::radialDistance($points, $toleranceSq);
        $points = SimplifyHelper::simplifyDouglasPeucker($points, $toleranceSq);

        $this->points = $points;

        return $this;
    }

    /**
     * Array representation of segment data.
     * @return array
     */
    public function toArray() : array
    {
        return [
            'points' => SerializationHelper::toArray($this->points),
        ];
    }
}
