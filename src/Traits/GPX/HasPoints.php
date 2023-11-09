<?php

namespace GPXToolbox\Traits\GPX;

use GPXToolbox\Helpers\GPX\PointHelper;
use GPXToolbox\Models\GPX\Bounds;
use GPXToolbox\Models\GPX\Point;
use GPXToolbox\Models\GPX\PointCollection;

trait HasPoints
{
    /**
     * Get a list of points.
     *
     * @return PointCollection
     */
    abstract public function getPoints(): PointCollection;

    /**
     * Set a list of points.
     *
     * @param PointCollection
     * @return $this
     */
    public function setPoints(PointCollection $points)
    {
        $this->getPoints()->fill($points);

        return $this;
    }

    /**
     * Add a point.
     *
     * @param Point $point
     * @return $this
     */
    public function addPoint(Point $point)
    {
        $this->getPoints()->add($point);

        return $this;
    }

    /**
     * Get the bounds of a list of points.
     *
     * @return array
     */
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

    /**
     * Simplify a list of points.
     *
     * @param float $tolerance
     * @param bool $highestQuality
     * @return $this
     */
    public function simplify(float $tolerance = 1.0, bool $highestQuality = false)
    {
        $points = $this->getPoints();

        $simplifiedPoints = PointHelper::simplify($points, $tolerance, $highestQuality);

        $clone = clone $this;
        $clone->setPoints($simplifiedPoints);

        return $clone;
    }
}
