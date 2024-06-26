<?php

namespace GPXToolbox\Models\GeoJSON;

use GPXToolbox\Helpers\SerializationHelper;

class Feature
{
    /**
     * Feature type.
     * @var string
     */
    protected $type = 'Feature';

    /**
     * Geometry object representing points, curves,
     * and surfaces in coordinate space.
     * @var Geometry
     */
    public $geometry = null;

    /**
     * A list of properties.
     * @var array|null
     */
    public $properties = null;

    /**
     * Feature constructor.
     */
    public function __construct($geometryType)
    {
        $this->geometry = new Geometry($geometryType);
    }

    /**
     * Array representation of feature data.
     * @return array
     */
    public function toArray() : array
    {
        return [
            'type'       => $this->type,
            'geometry'   => SerializationHelper::toArray($this->geometry),
            'properties' => $this->properties,
        ];
    }
}
