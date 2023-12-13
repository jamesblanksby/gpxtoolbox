<?php

namespace GPXToolbox\Models\Analytics;

use GPXToolbox\Abstracts\Model;
use GPXToolbox\Models\Gpx\PointCollection;
use GPXToolbox\Traits\Gpx\HasPoints;
use GPXToolbox\Traits\Gpx\HasStatistics;

final class Split extends Model
{
    use HasPoints;
    use HasStatistics;

    public PointCollection $points;

    public function __construct($collection = null)
    {
        $this->points = new PointCollection();
        parent::__construct($collection);
    }

    public function getPoints(): PointCollection
    {
        return $this->points;
    }
}
