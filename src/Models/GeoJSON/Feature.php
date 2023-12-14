<?php

namespace GPXToolbox\Models\GeoJson;

use GPXToolbox\Abstracts\Model;

final class Feature extends Model
{
    protected string $type = 'Feature';

    public Geometry $geometry;

    public array $properties = [];

    public function __construct(string $geometry, ?array $collection = null)
    {
        parent::__construct($collection);
        $this->geometry = new Geometry($geometry);
    }

    public function setProperties(array $properties)
    {
        $this->properties = $properties;

        return $this;
    }

    public function addProperty(string $key, $value)
    {
        $this->properties[$key] = $value;

        return $this;
    }

    public function getGeometry(): Geometry
    {
        return $this->geometry;
    }
}
