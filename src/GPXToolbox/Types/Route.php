<?php

namespace GPXToolbox\Types;

use GPXToolbox\Helpers\SerializationHelper;
use GPXToolbox\Interfaces\ArraySerializableInterface;
use GPXToolbox\Types\Extensions\ExtensionAbstract;

class Route implements ArraySerializableInterface
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
     * @var Link[]
     */
    public $links = [];

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
     * A list of extensions.
     * @var ExtensionAbstract[]
     */
    public $extensions = [];

    /**
     * A list of route points.
     * @var Point[]
     */
    public $points = [];

    /**
     * Add link to route.
     * @param Link $link
     * @return self
     */
    public function addLink(Link $link): self
    {
        array_push($this->links, $link);

        return $this;
    }

    /**
     * Add extension to route.
     * @param ExtensionAbstract $extension
     * @return self
     */
    public function addExtension(ExtensionAbstract $extension): self
    {
        array_push($this->extensions, $extension);

        return $this;
    }

    /**
     * Add point to route.
     * @param Point $point
     * @return self
     */
    public function addPoint(Point $point): self
    {
        array_push($this->points, $point);

        return $this;
    }

    /**
     * Array representation of route data.
     * @return mixed[]
     */
    public function toArray(): array
    {
        return [
            'name'       => $this->name,
            'cmt'        => $this->cmt,
            'desc'       => $this->desc,
            'src'        => $this->src,
            'links'      => SerializationHelper::toArray($this->links),
            'number'     => $this->number,
            'type'       => $this->type,
            'extensions' => SerializationHelper::toArray($this->extensions),
            'rtept'      => SerializationHelper::toArray($this->points),
        ];
    }
}
