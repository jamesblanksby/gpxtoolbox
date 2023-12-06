<?php

namespace GPXToolbox\Models\Analytics;

use GPXToolbox\Abstracts\Model;
use GPXToolbox\Models\GPX\PointCollection;
use GPXToolbox\Traits\GPX\HasPoints;
use GPXToolbox\Traits\GPX\HasStatistics;

final class Split extends Model
{
    use HasPoints;
    use HasStatistics;

    /**
     * @var PointCollection A list of points within the split.
     */
    public $points;

    /**
     * Split constructor.
     *
     * @param array|null $collection
     */
    public function __construct($collection = null)
    {
        $this->points = new PointCollection();
        parent::__construct($collection);
    }

    /**
     * Get a list of points associated with the split.
     *
     * @return PointCollection
     */
    public function getPoints(): PointCollection
    {
        return $this->points;
    }
}
