<?php

namespace GPXToolbox\Models\Analytics;

use GPXToolbox\Models\GPX\PointCollection;
use GPXToolbox\Traits\GPX\HasStatistics;

final class SplitCollection extends PointCollection
{
    use HasStatistics;

    /**
     * Add a split to the collection based on an array of points.
     *
     * @param PointCollection $points
     *
     * @return $this
     */
    public function addSplit(PointCollection $points)
    {
        $split = new Split();
        $split->setPoints($points);

        $this->add($split);

        return $this;
    }
}
