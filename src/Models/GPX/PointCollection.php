<?php

namespace GPXToolbox\Models\GPX;

use GPXToolbox\Abstracts\GPX\GPXTypeCollection;
use GPXToolbox\Traits\GPX\HasPoints;

class PointCollection extends GPXTypeCollection
{
    use HasPoints;

    /**
     * Get a list of points associated with the collection.
     *
     * @return PointCollection
     */
    public function getPoints(): PointCollection
    {
        return $this;
    }

    /**
     * Get a list of coordinates of the point collection.
     *
     * @return array
     */
    public function getCoordinates(): array
    {
        $points = $this->getPoints();

        $coordinates = $points->map(function ($point) {
            return $point->getCoordinates();
        })->toArray();

        return $coordinates;
    }
}
