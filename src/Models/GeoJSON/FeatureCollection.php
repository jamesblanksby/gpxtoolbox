<?php

namespace GPXToolbox\Models\GeoJson;

use GPXToolbox\Abstracts\Collection;

final class FeatureCollection extends Collection
{
    protected string $type = 'FeatureCollection';

    public function addFeature(Feature $feature)
    {
        $this->add($feature);

        return $this;
    }

    public function toArray(): array
    {
        $array = [
            'type' => $this->type,
            'features' => parent::toArray(),
        ];

        return $array;
    }
}
