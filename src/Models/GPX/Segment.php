<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Model;
use GPXToolbox\Traits\Gpx\HasPoints;
use GPXToolbox\Traits\Gpx\HasStatistics;

final class Segment extends Model
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
