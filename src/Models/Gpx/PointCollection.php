<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Collection;
use GPXToolbox\Traits\Gpx\HasPoints;

class PointCollection extends Collection
{
    use HasPoints;

    /**
     * @inheritDoc
     */
    protected ?string $class = Point::class;

    /**
     * Get all points in the collection.
     *
     * @return PointCollection
     */
    public function getPoints(): PointCollection
    {
        return $this;
    }

    /**
     * Get coordinates of all points in the collection.
     *
     * @return array
     */
    public function getCoordinates(): array
    {
        $points = $this->getPoints();

        $coordinates = [];

        foreach ($points->all() as $point) {
            $coordinates[] = $point->getCoordinates();
        }

        return $coordinates;
    }
}
