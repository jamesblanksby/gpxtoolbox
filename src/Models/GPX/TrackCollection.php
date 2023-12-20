<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Collection;
use GPXToolbox\Traits\Gpx\HasSplits;
use GPXToolbox\Traits\Gpx\HasStatistics;

class TrackCollection extends Collection
{
    use HasSplits;
    use HasStatistics;

    /**
     * @inheritDoc
     */
    protected ?string $class = Track::class;

    /**
     * Get all track points from the collection.
     *
     * @return PointCollection
     */
    public function getPoints(): PointCollection
    {
        $points = new PointCollection();

        foreach ($this->all() as $track) {
            $points = $points->merge($track->getPoints());
        }

        return $points;
    }
}
