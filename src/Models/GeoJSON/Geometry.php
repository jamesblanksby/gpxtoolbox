<?php

namespace GPXToolbox\Models\GeoJSON;

use GPXToolbox\Abstracts\Model;

class Geometry extends Model
{
    /**
     * The GeoJSON geometry types.
     */
    public const POINT = 'Point';
    public const LINE_STRING = 'LineString';
    public const POLYGON = 'Polygon';
    public const MULTI_POINT = 'MultiPoint';
    public const MULTI_LINE_STRING = 'MultiLineString';
    public const MULTI_POLYGON = 'MultiPolygon';
    public const GEOMETRY_COLLECTION = 'GeometryCollection';

    /**
     * @var string The type of the geometry.
     */
    public $type = '';

    /**
     * @var CoordinateCollection The coordinates of the geometry.
     */
    public $coordinates;

    /**
     * Geometry constructor.
     *
     * @param string $type
     * @param array|null $collection
     */
    public function __construct(string $type, ?array $collection = null)
    {
        $this->coordinates = new CoordinateCollection();
        parent::__construct($collection);
        $this->type = $type;
    }

    /**
     * Add coordinates to the geometry.
     *
     * @param float $longitude
     * @param float $latitude
     * @return $this
     */
    public function addCoordinate(float $longitude, float $latitude)
    {
        $coordinates = [$longitude, $latitude,];

        if ($this->type === self::POINT) {
            $this->coordinates->fill($coordinates);
        } else {
            $this->coordinates->add($coordinates);
        }

        return $this;
    }
}
