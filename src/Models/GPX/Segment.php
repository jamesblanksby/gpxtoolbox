<?php

namespace GPXToolbox\Models\GPX;

use GPXToolbox\Abstracts\GPX\GPXType;
use GPXToolbox\Traits\GPX\HasPoints;
use GPXToolbox\Traits\GPX\HasStatistics;

final class Segment extends GPXType
{
    use HasPoints;
    use HasStatistics;

    /**
     * @var PointCollection A list of points associated with the segment.
     */
    public $trkpt;

    /**
     * Segment constructor.
     *
     * @param array|null $collection
     */
    public function __construct($collection = null)
    {
        $this->trkpt = new PointCollection();
        parent::__construct($collection);
    }

    /**
     * Get a list of points associated with the segment.
     *
     * @return PointCollection
     */
    public function getPoints(): PointCollection
    {
        return $this->trkpt;
    }
}
