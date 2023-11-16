<?php

namespace GPXToolbox\Models;

use GPXToolbox\Abstracts\Model;
use GPXToolbox\Models\GeoJSON\FeatureCollection;

class GeoJSON extends Model
{
    /**
     * @var string The type of the collection.
     */
    protected $type = 'FeatureCollection';

    /**
     * @var FeatureCollection A list of features in the collection.
     */
    public $features;

    /**
     * Collection constructor.
     *
     * @param array|null $collection
     */
    public function __construct(?array $collection = null)
    {
        $this->features = new FeatureCollection();
        parent::__construct($collection);
    }

    /**
     * Set a list of features associated with the collection.
     *
     * @param FeatureCollection
     * @return $this
     */
    public function setFeatures($features)
    {
        $this->getFeatures()->fill($features);

        return $this;
    }

    /**
     * Add a feature to the collection.
     *
     * @param mixed $value
     * @return $this
     */
    public function addFeature($value)
    {
        $this->getFeatures()->add($value);

        return $this;
    }

    /**
     * Get a list of features associated with the collection.
     *
     * @return FeatureCollection
     */
    public function getFeatures(): FeatureCollection
    {
        return $this->features;
    }
}
