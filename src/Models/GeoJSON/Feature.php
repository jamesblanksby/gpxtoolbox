<?php

namespace GPXToolbox\Models\GeoJSON;

use GPXToolbox\Abstracts\Model;

final class Feature extends Model
{
    /**
     * @var string The type of the feature.
     */
    protected $type = 'Feature';

    /**
     * @var Geometry The geometry associated with the feature.
     */
    public $geometry;

    /**
     * @var PropertyCollection The properties associated with the feature.
     */
    public $properties;

    /**
     * Feature constructor.
     *
     * @param string $geometry
     * @param array|null $collection
     */
    public function __construct(string $geometry, ?array $collection = null)
    {
        $this->properties = new PropertyCollection();
        parent::__construct($collection);
        $this->geometry = new Geometry($geometry);
    }

    /**
     * Set a list of properties associated with the feature.
     *
     * @param array $properties
     * @return $this
     */
    public function setProperties(array $properties)
    {
        $this->getProperties()->fill($properties);

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
        $this->getProperties()->set($key, $value);

        return $this;
    }

    /**
     * Get a list of properties associated with the feature.
     *
     * @return PropertyCollection
     */
    public function getProperties(): PropertyCollection
    {
        return $this->properties;
    }

    /**
     * Get geometry associated with the feature.
     *
     * @return Geometry
     */
    public function getGeometry(): Geometry
    {
        return $this->geometry;
    }
}
