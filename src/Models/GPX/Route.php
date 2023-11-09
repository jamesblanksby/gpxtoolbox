<?php

namespace GPXToolbox\Models\GPX;

use GPXToolbox\Abstracts\GPX\GPXType;
use GPXToolbox\Traits\GPX\HasLinks;
use GPXToolbox\Traits\GPX\HasPoints;

class Route extends GPXType
{
    use HasLinks;
    use HasPoints;

    /**
     * @var string|null The name of the route.
     */
    public $name = null;

    /**
     * @var string|null A comment or description of the route.
     */
    public $cmt = null;

    /**
     * @var string|null A more detailed description of the route.
     */
    public $desc = null;

    /**
     * @var string|null The source of the route data.
     */
    public $src = null;

    /**
     * @var LinkCollection A list of links associated with the route.
     */
    public $link;

    /**
     * @var int|null The route number.
     */
    public $number = null;

    /**
     * @var string|null The type or category of the route.
     */
    public $type = null;

    /**
     * @var PointCollection A list of points associated with the route.
     */
    public $rtept;

    /**
     * Route constructor.
     *
     * @param array|null $collection
     */
    public function __construct($collection = null)
    {
        $this->link = new LinkCollection();
        $this->rtept = new PointCollection();
        parent::__construct($collection);
    }

    /**
     * Get a list of points associated with the route.
     *
     * @return PointCollection
     */
    public function getPoints(): PointCollection
    {
        return $this->rtept;
    }
}
