<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Xml;
use GPXToolbox\Traits\Gpx\HasLinks;
use GPXToolbox\Traits\Gpx\HasPoints;

class Route extends Xml
{
    use HasLinks;
    use HasPoints;

    /**
     * The name of the route.
     *
     * @var string|null
     */
    public ?string $name = null;

    /**
     * A comment about the route.
     *
     * @var string|null
     */
    public ?string $cmt = null;

    /**
     * A description of the route.
     *
     * @var string|null
     */
    public ?string $desc = null;

    /**
     * The source of the route data.
     *
     * @var string|null
     */
    public ?string $src = null;

    /**
     * A collection of links associated with the route.
     *
     * @var LinkCollection
     */
    public LinkCollection $link;

    /**
    * The number of the route.
    *
    * @var int|null
    */
    public ?int $number = null;

    /**
     * The type of the route.
     *
     * @var string|null
     */
    public ?string $type = null;

    /**
     * A collection of points that make up the route.
     *
     * @var PointCollection
     */
    public PointCollection $rtept;

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
     * Get the points that make up the route.
     *
     * @return PointCollection
     */
    public function getPoints(): PointCollection
    {
        return $this->rtept;
    }

    /**
     * Get properties of the route excluding the route points.
     *
     * @return array
     */
    public function getProperties(): array
    {
        $properties = self::unwrapAttributes($this->toArray());
        unset($properties['rtept']);

        return $properties;
    }
}
