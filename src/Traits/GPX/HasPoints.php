<?php

namespace GPXToolbox\Traits\Gpx;

use GPXToolbox\Helpers\Gpx\PointHelper;
use GPXToolbox\Models\Gpx\Bounds;
use GPXToolbox\Models\Gpx\Point;
use GPXToolbox\Models\Gpx\PointCollection;

trait HasPoints
{
    public function setPoints(PointCollection $points)
    {
        $this->getPoints()->clear()->fill($points);

        return $this;
    }

    public function addPoint(Point $point)
    {
        $this->getPoints()->add($point);

        return $this;
    }

    abstract public function getPoints(): PointCollection;

    public function getBounds()
    {
        $latitudes = [];
        $longitudes = [];

        $points = $this->getPoints();

        foreach ($points as $point) {
            $latitudes[] = $point->getLatitude();
            $longitudes[] = $point->getLongitude();
        }

        $minlat = min($latitudes);
        $minlon = min($longitudes);
        $maxlat = max($latitudes);
        $maxlon = max($longitudes);

        $properties = compact(
            'minlat',
            'minlon',
            'maxlat',
            'maxlon',
        );

        return new Bounds($properties);
    }

    public function simplify(float $tolerance = 0.1, bool $highestQuality = true)
    {
        $points = $this->getPoints();

        $simplifiedPoints = PointHelper::simplify($points, $tolerance, $highestQuality);

        $clone = unserialize(serialize($this));
        $clone->setPoints($simplifiedPoints);

        return $clone;
    }
}
