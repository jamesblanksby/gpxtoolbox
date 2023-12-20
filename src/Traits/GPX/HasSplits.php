<?php

namespace GPXToolbox\Traits\Gpx;

use GPXToolbox\GPXToolbox;
use GPXToolbox\Helpers\Gpx\PointHelper;
use GPXToolbox\Models\Analytics\SplitCollection;
use GPXToolbox\Models\Gpx\PointCollection;

trait HasSplits
{
    /**
     * Get splits for the model.
     *
     * @param int|null $interval
     * @return SplitCollection
     */
    public function getSplits(?int $interval = 1000): SplitCollection
    {
        $points = $this->getPoints();

        $prevPoint = $points->first();

        $distance = 0.0;

        $distanceThreshold = GPXToolbox::getConfiguration()->getDistanceThreshold();

        $splits = new SplitCollection();
        $splitPoints = new PointCollection();

        foreach ($points->all() as $point) {
            $splitPoints->add($point);

            $difference = PointHelper::get3dDistance($prevPoint, $point);

            if ($difference > $distanceThreshold) {
                $distance += $difference;
                $prevPoint = $point;
            }

            if ($distance < $interval) {
                continue;
            }

            $splits->addSplit(clone $splitPoints);

            $distance = 0.0;
            $splitPoints->clear();
        }

        $splits->addSplit($splitPoints);

        return $splits;
    }
}
