<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Collection;
use GPXToolbox\Traits\Gpx\HasSplits;
use GPXToolbox\Traits\Gpx\HasStatistics;

class SegmentCollection extends Collection
{
    use HasSplits;
    use HasStatistics;

    /**
     * @inheritDoc
     */
    protected ?string $class = Segment::class;

    /**
     * Get the track points from all segments in the collection.
     *
     * @return PointCollection
     */
    public function getPoints(): PointCollection
    {
        $points = new PointCollection();

        foreach ($this->all() as $segment) {
            $points = $points->merge($segment->getPoints());
        }

        return $points;
    }
}
