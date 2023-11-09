<?php

namespace GPXToolbox\Traits\GPX;

use GPXToolbox\Helpers\GPX\PointHelper;
use GPXToolbox\Models\Analytics\SplitCollection;

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

        $splits = new SplitCollection();

        $distance = 0.0;
        $splitPoints = [];

        for ($a = 0; $a < count($points); $a++) {
            $point = $points[$a];

            $splitPoints[] = $point;

            if ($a === 0) {
                continue;
            }

            $difference = PointHelper::get3dDistance($point, $points[($a - 1)]);

            // @TODO validate distance threshold

            $distance += $difference;

            if ($distance < $interval) {
                continue;
            }

            $splits->addSplit($splitPoints);

            $distance = 0.0;
            $splitPoints = [];
        }

        $splits->addSplit($splitPoints);

        return $splits;
    }
}
