<?php

namespace GPXToolbox\Types;

use GPXToolbox\Helpers\SerializationHelper;

class Route
{
    /**
     * GPS name of route.
     * @var string|null
     */
    public $name = null;

    /**
     * GPS comment for route.
     * @var string|null
     */
    public $cmt = null;

    /**
     * Text description of route for user.
     * @var string|null
     */
    public $desc = null;

    /**
     * Source of data.
     * Included to give user some idea of reliability and accuracy of data.
     * @var string|null
     */
    public $src = null;

    /**
     * Links to external information about the route.
     * @var Link[]|null
     */
    public $links = null;

    /**
     * GPS route number.
     * @var integer|null
     */
    public $number = null;

    /**
     * Type (classification) of route.
     * @var string|null
     */
    public $type = null;

    /**
     * A list of route points.
     * @var Point[]
     */
    public $points = [];

    /**
     * Add point to route.
     * @param Point $rtept
     * @return self
     */
    public function addPoint(Point $rtept) : self
    {
        array_push($this->points, $rtept);

        return $this;
    }

    /**
     * Array representation of route data.
     * @return array
     */
    public function toArray() : array
    {
        return [
            'name'   => $this->name,
            'cmt'    => $this->cmt,
            'desc'   => $this->desc,
            'src'    => $this->src,
            'links'  => SerializationHelper::toArray($this->links),
            'number' => $this->number,
            'type'   => $this->type,
            'points' => SerializationHelper::toArray($this->points),
        ];
    }
}
