<?php

namespace GPXToolbox\Models\GeoJson;

use GPXToolbox\Abstracts\Model;
use GPXToolbox\Models\Gpx\PointCollection;

class Geometry extends Model
{
    /**
     * Geometry types.
     */
    public const POINT = 'Point';
    public const LINE_STRING = 'LineString';
    public const POLYGON = 'Polygon';
    public const MULTI_POINT = 'MultiPoint';
    public const MULTI_LINE_STRING = 'MultiLineString';
    public const MULTI_POLYGON = 'MultiPolygon';
    public const GEOMETRY_COLLECTION = 'GeometryCollection';

    /**
     * @var string The GeoJSON type.
     */
    public string $type = '';

    /**
     * @var CoordinateCollection Coordinates associated with the geometry.
     */
    public CoordinateCollection $coordinates;

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
     * Set coordinates for the geometry.
     *
     * @param PointCollection $points
     * @return $this
     */
    public function setCoordinates(PointCollection $points)
    {
        if ($this->type === self::POINT) {
            $point = $points->first();
            $this->addCoordinate(...$point->getCoordinates());
        } else {
            $coordinates = $points->getCoordinates();
            $this->coordinates->clear()->fill($coordinates);
        }

        return $this;
    }

    /**
     * Add a coordinate to the geometry.
     *
     * @param float $longitude
     * @param float $latitude
     * @return $this
     */
    public function addCoordinate(float $longitude, float $latitude)
    {
        $coordinates = [$longitude, $latitude,];

        if ($this->type === self::POINT) {
            $this->coordinates->clear()->fill($coordinates);
        } else {
            $this->coordinates->add($coordinates);
        }

        return $this;
    }
}
