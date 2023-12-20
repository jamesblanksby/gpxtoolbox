<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Xml;
use GPXToolbox\Traits\Gpx\HasPoints;
use GPXToolbox\Traits\Gpx\HasStatistics;

class Segment extends Xml
{
    use HasPoints;
    use HasStatistics;

    /**
     * The collection of track points in the segment.
     *
     * @var PointCollection
     */
    public PointCollection $trkpt;

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
     * Get the track points in the segment.
     *
     * @return PointCollection
     */
    public function getPoints(): PointCollection
    {
        return $this->trkpt;
    }
}
