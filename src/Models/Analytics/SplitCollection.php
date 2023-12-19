<?php

namespace GPXToolbox\Models\Analytics;

use GPXToolbox\Models\Gpx\PointCollection;

class SplitCollection extends PointCollection
{
    protected ?string $class = Split::class;

    public function addSplit(PointCollection $points)
    {
        $split = new Split();
        $split->setPoints($points);

        $this->add($split);

        return $this;
    }
}
