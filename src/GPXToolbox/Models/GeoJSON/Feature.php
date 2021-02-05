<?php

namespace GPXToolbox\Models\GeoJSON;

class Feature
{
    /**
     * Feature type.
     * @var string
     */
    public $type = 'Feature';

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
}
