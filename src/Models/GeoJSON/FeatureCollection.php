<?php

namespace GPXToolbox\Models\GeoJSON;

use GPXToolbox\Abstracts\Collection;

class FeatureCollection extends Collection
{
    /**
     * @var string The type of the collection.
     */
    protected $type = 'FeatureCollection';

    /**
     * Add a feature to the collection.
     *
     * @param Feature $feature
     * @return $this
     */
    public function addFeature(Feature $feature)
    {
        $this->add($feature);

        return $this;
    }

    /**
     * Get the feature collection's attributes as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        $array = [
            'type' => $this->type,
            'features' => parent::toArray(),
        ];

        return $array;
    }
}
