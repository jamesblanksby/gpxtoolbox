<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Collection;
use GPXToolbox\Traits\Gpx\HasSplits;
use GPXToolbox\Traits\Gpx\HasStatistics;

final class SegmentCollection extends Collection
{
    use HasSplits;
    use HasStatistics;

    protected ?string $class = Segment::class;

    public function getPoints(): PointCollection
    {
        $points = new PointCollection();

        foreach ($this->all() as $segment) {
            $points = $points->merge($segment->getPoints());
        }

        return $points;
    }
}
