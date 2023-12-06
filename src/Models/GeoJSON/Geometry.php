<?php

namespace GPXToolbox\Models\GeoJson;

use GPXToolbox\Abstracts\GPX\GeoJsonType;
use GPXToolbox\Models\GPX\PointCollection;

final class Geometry extends GeoJsonType
{
    /**
     * The GeoJson geometry types.
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
     * Set a list of points associated with the geometry.
     *
     * @param PointCollection $points
     * @return $this
     */
    public function setCoordinates(PointCollection $points)
    {
        if ($this->type === self::POINT) {
            $point = $points->first();

            $this->addCoordinate($point->getLongitude(), $point->getLatitude());
        } else {
            $coordinates = $points->getCoordinates();

            $this->coordinates->fill($coordinates);
        }

        return $this;
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
