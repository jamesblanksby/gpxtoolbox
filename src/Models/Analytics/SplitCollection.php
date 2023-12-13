<?php

namespace GPXToolbox\Models\Analytics;

use GPXToolbox\Models\Gpx\PointCollection;
use GPXToolbox\Traits\Gpx\HasStatistics;

final class SplitCollection extends PointCollection
{
    use HasStatistics;

    protected ?string $class = Split::class;

    public function addSplit(PointCollection $points)
    {
        $split = new Split();
        $split->setPoints($points);

        $this->add($split);

        return $this;
    }
}
