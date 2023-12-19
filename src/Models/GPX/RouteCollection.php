<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Collection;

class RouteCollection extends Collection
{
    protected ?string $class = Route::class;

    public function getPoints(): PointCollection
    {
        $points = new PointCollection();

        foreach ($this->all() as $route) {
            $points = $points->merge($route->getPoints());
        }

        return $points;
    }
}
