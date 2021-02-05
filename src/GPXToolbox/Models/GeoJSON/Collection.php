<?php

namespace GPXToolbox\Models\GeoJSON;

class Collection
{
    /**
     * Collection type.
     * @var string
     */
    public $type = 'FeatureCollection';

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
}
