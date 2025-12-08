<?php

namespace GPXToolbox\Traits\Gpx;

use GPXToolbox\Helpers\Gpx\PointHelper;
use GPXToolbox\Models\Gpx\Bounds;
use GPXToolbox\Models\Gpx\Point;
use GPXToolbox\Models\Gpx\PointCollection;

trait HasPoints
{
    /**
     * Set points for the model.
     *
     * @param PointCollection $points
     * @return $this
     */
    public function setPoints(PointCollection $points): self
    {
        $this->getPoints()->clear()->fill($points);

        return $this;
    }

    /**
     * Add a point to the model.
     *
     * @param Point $point
     * @return $this
     */
    public function addPoint(Point $point): self
    {
        $this->getPoints()->add($point);

        return $this;
    }

    /**
     * Get the points collection.
     *
     * @return PointCollection
     */
    abstract public function getPoints(): PointCollection;

    /**
     * Get the bounds of the points.
     *
     * @return Bounds
     */
    public function getBounds(): Bounds
    {
        $points = $this->getPoints();

        return PointHelper::getBounds($points);
    }

    /**
     * Simplify the points with a given tolerance.
     *
     * @param float $tolerance
     * @param bool $highestQuality
     * @return $this
     */
    public function simplify(float $tolerance = 0.1, bool $highestQuality = true): self
    {
        $points = $this->getPoints();

        $simplifiedPoints = PointHelper::simplify($points, $tolerance, $highestQuality);

        $clone = unserialize(serialize($this));
        $clone->setPoints($simplifiedPoints);

        return $clone;
    }
}
