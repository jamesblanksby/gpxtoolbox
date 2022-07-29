<?php

namespace GPXToolbox\Models\GeoJSON;

use GPXToolbox\Helpers\SerializationHelper;

class Collection
{
    /**
     * Collection type.
     * @var string
     */
    protected $type = 'FeatureCollection';

    /**
     * A list of features.
     * @var Feature[]
     */
    public $features = [];

    /**
     * A list of properties.
     * @var array
     */
    public $properties = [];

    /**
     * Add feature to collection.
     * @param Feature $feature
     * @return self
     */
    public function addFeature(Feature $feature) : self
    {
        array_push($this->features, $feature);

        return $this;
    }

    /**
     * Add property to collection.
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
     * Array representation of collection data.
     * @return array
     */
    public function toArray() : array
    {
        return SerializationHelper::filterEmpty([
            'type'       => $this->type,
            'features'   => SerializationHelper::toArray($this->features),
            'properties' => SerializationHelper::toArray($this->properties),
        ]);
    }
}
