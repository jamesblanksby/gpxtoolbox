<?php

namespace GPXToolbox\Models\GeoJson;

use GPXToolbox\Abstracts\Collection;

class FeatureCollection extends Collection
{
    /**
     * @inheritdoc
     */
    protected ?string $class = Feature::class;

    /**
     * @var string The GeoJSON type.
     */
    protected string $type = 'FeatureCollection';

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
     * Convert the feature collection to an array.
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
