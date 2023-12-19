<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Xml;
use GPXToolbox\Traits\Gpx\HasPoints;
use GPXToolbox\Traits\Gpx\HasStatistics;

class Segment extends Xml
{
    use HasPoints;
    use HasStatistics;

    public PointCollection $trkpt;

    public function __construct($collection = null)
    {
        $this->trkpt = new PointCollection();
        parent::__construct($collection);
    }

    public function getPoints(): PointCollection
    {
        return $this->trkpt;
    }
}
