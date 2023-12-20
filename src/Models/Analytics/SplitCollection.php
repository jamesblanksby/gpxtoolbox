<?php

namespace GPXToolbox\Models\Analytics;

use GPXToolbox\Models\Gpx\PointCollection;

class SplitCollection extends PointCollection
{
    /**
     * @inheritdoc
     */
    protected ?string $class = Split::class;

    /**
     * Add a split to the collection with the given points.
     *
     * @param PointCollection $points
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
