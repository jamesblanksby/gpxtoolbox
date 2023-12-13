<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Collection;
use GPXToolbox\Traits\Gpx\HasPoints;

class PointCollection extends Collection
{
    use HasPoints;

    protected string $type = Point::class;

    public function getPoints(): PointCollection
    {
        return $this;
    }

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
