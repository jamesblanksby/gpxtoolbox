<?php

namespace GPXToolbox\Models\GPX;

use GPXToolbox\Traits\GPX\HasSplits;
use GPXToolbox\Traits\GPX\HasStatistics;

final class TrackCollection extends PointCollection
{
    use HasSplits;
    use HasStatistics;

    /**
     * Get all points from the tracks in the collection.
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
