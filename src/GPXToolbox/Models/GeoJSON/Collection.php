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
     * @var array|null
     */
    public $properties = null;

    /**
     * Add feature to collection.
     * @param Feature $feature
     * @return boolean
     */
    public function addFeature(Feature $feature) : bool
    {
        return array_push($this->features, $feature);
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
            'properties' => $this->properties,
        ]);
    }
}
