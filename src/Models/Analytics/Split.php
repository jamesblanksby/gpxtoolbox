<?php

namespace GPXToolbox\Models\Analytics;

use GPXToolbox\Abstracts\Model;
use GPXToolbox\Models\Gpx\PointCollection;
use GPXToolbox\Traits\Gpx\HasPoints;
use GPXToolbox\Traits\Gpx\HasStatistics;

class Split extends Model
{
    use HasPoints;
    use HasStatistics;

    /**
     * @var PointCollection A collection of points associated with the split.
     */
    public PointCollection $points;

    /**
     * Split constructor.
     *
     * @param mixed $collection
     */
    public function __construct($collection = null)
    {
        $this->points = new PointCollection();
        parent::__construct($collection);
    }

    /**
     * Get the points associated with the split.
     *
     * @return PointCollection
     */
    public function getPoints(): PointCollection
    {
        return $this->points;
    }
}
