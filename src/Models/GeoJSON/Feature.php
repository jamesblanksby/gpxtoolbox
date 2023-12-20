<?php

namespace GPXToolbox\Models\GeoJson;

use GPXToolbox\Abstracts\Model;

class Feature extends Model
{
    /**
     * @var string The GeoJSON type.
     */
    protected string $type = 'Feature';

    /**
     * @var Geometry The geometry associated with the feature.
     */
    public Geometry $geometry;

    /**
     * @var array Properties associated with the feature.
     */
    public array $properties = [];

    /**
     * Feature constructor.
     *
     * @param string $geometry
     * @param array|null $collection
     */
    public function __construct(string $geometry, ?array $collection = null)
    {
        parent::__construct($collection);
        $this->geometry = new Geometry($geometry);
    }

    /**
     * Set properties for the feature.
     *
     * @param array $properties
     * @return $this
     */
    public function setProperties(array $properties)
    {
        $this->properties = $properties;

        return $this;
    }

    /**
     * Add a property to the feature.
     *
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function addProperty(string $key, $value)
    {
        $this->properties[$key] = $value;

        return $this;
    }

    /**
     * Get the geometry associated with the feature.
     *
     * @return Geometry
     */
    public function getGeometry(): Geometry
    {
        return $this->geometry;
    }
}
