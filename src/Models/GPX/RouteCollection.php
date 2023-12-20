<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Collection;

class RouteCollection extends Collection
{
    /**
     * @inheritDoc
     */
    protected ?string $class = Route::class;

    /**
     * Get the points from all routes in the collection.
     *
     * @return PointCollection
     */
    public function getPoints(): PointCollection
    {
        $points = new PointCollection();

        foreach ($this->all() as $route) {
            $points = $points->merge($route->getPoints());
        }

        return $points;
    }
}
