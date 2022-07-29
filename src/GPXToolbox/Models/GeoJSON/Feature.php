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
    public $geometry;

    /**
     * A list of properties.
     * @var array
     */
    public $properties = [];

    /**
     * Feature constructor.
     */
    public function __construct($geometryType)
    {
        $this->geometry = new Geometry($geometryType);
    }

    /**
     * Add property to feature.
     * @param string $key
     * @param string $value
     * @return self
     */
    public function addProperty(string $key, string $value) : self
    {
        $this->properties [$key]= $value;
        
        return $this;
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
            'properties' => SerializationHelper::toArray($this->properties),
        ];
    }
}
