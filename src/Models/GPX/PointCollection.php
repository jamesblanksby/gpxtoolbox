<?php

namespace GPXToolbox\Models\GPX;

use GPXToolbox\Abstracts\Collection;
use GPXToolbox\Traits\GPX\HasPoints;

class PointCollection extends Collection
{
    use HasPoints;

    /**
     * Get a list of points associated with the collection.
     *
     * @return PointCollection
     */
    public function getPoints(): PointCollection
    {
        return $this;
    }
}
