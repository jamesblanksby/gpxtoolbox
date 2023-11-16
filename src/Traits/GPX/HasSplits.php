<?php

namespace GPXToolbox\Traits\GPX;

use GPXToolbox\GPXToolbox;
use GPXToolbox\Helpers\GPX\PointHelper;
use GPXToolbox\Models\Analytics\SplitCollection;
use GPXToolbox\Models\GPX\PointCollection;

trait HasSplits
{
    /**
     * Get splits from a list of points based on a specified interval.
     *
     * @param int $interval
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

        for ($a = 0; $a < $points->count(); $a++) {
            $point = $points->get($a);

            $splitPoints->add($point);

            if ($a === 0) {
                continue;
            }

            $difference = PointHelper::get3dDistance($prevPoint, $point);

            if (!$distanceThreshold || $difference > $distanceThreshold) {
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
