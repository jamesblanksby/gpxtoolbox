<?php

namespace GPXToolbox\Models\GeoJSON;

use GPXToolbox\Helpers\SerializationHelper;
use GPXToolbox\Interfaces\ArraySerializableInterface;

class Feature implements ArraySerializableInterface
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
     * @var array<mixed>
     */
    public $properties = [];

    /**
     * Feature constructor.
     * @param string $type
     */
    public function __construct(string $type)
    {
        $this->geometry = new Geometry($type);
    }

    /**
     * Add property to feature.
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function addProperty(string $key, $value): self
    {
        $this->properties [$key]= $value;

        return $this;
    }

    /**
     * Array representation of feature data.
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return SerializationHelper::filterNotNull([
            'type'       => $this->type,
            'geometry'   => SerializationHelper::toArray($this->geometry),
            'properties' => $this->properties,
        ]);
    }
}
