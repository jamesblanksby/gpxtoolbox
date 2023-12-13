<?php

namespace GPXToolbox\Models\GeoJson;

use GPXToolbox\Abstracts\Model;

final class Feature extends Model
{
    protected string $type = 'Feature';

    public Geometry $geometry;

    public PropertyCollection $properties;

    public function __construct(string $geometry, ?array $collection = null)
    {
        $this->properties = new PropertyCollection();
        parent::__construct($collection);
        $this->geometry = new Geometry($geometry);
    }

    public function setProperties(array $properties)
    {
        $this->getProperties()->fill($properties);

        return $this;
    }

    public function addProperty(string $key, $value)
    {
        $this->getProperties()->set($key, $value);

        return $this;
    }

    public function getProperties(): PropertyCollection
    {
        return $this->properties;
    }

    public function getGeometry(): Geometry
    {
        return $this->geometry;
    }
}
