<?php

namespace GPXToolbox\Models\GeoJSON;

use GPXToolbox\Helpers\SerializationHelper;
use GPXToolbox\Interfaces\ArraySerializableInterface;

class Collection implements ArraySerializableInterface
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
     * Add feature to collection.
     * @param Feature $feature
     * @return self
     */
    public function addFeature(Feature $feature): self
    {
        array_push($this->features, $feature);

        return $this;
    }

    /**
     * Array representation of collection data.
     * @return mixed[]
     */
    public function toArray(): array
    {
        return SerializationHelper::filterNotNull([
            'type'       => $this->type,
            'features'   => SerializationHelper::toArray($this->features),
        ]);
    }
}
