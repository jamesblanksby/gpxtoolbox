<?php

namespace GPXToolbox\Traits\Gpx;

use GPXToolbox\GPXToolbox;
use GPXToolbox\Helpers\Gpx\PointHelper;
use GPXToolbox\Models\Analytics\SplitCollection;
use GPXToolbox\Models\Gpx\PointCollection;

trait HasSplits
{
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
