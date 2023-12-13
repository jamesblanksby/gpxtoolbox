<?php

namespace GPXToolbox\Models\GeoJson;

use GPXToolbox\Abstracts\Model;
use GPXToolbox\Models\Gpx\PointCollection;

final class Geometry extends Model
{
    public const POINT = 'Point';
    public const LINE_STRING = 'LineString';
    public const POLYGON = 'Polygon';
    public const MULTI_POINT = 'MultiPoint';
    public const MULTI_LINE_STRING = 'MultiLineString';
    public const MULTI_POLYGON = 'MultiPolygon';
    public const GEOMETRY_COLLECTION = 'GeometryCollection';

    public string $type = '';

    public CoordinateCollection $coordinates;

    public function __construct(string $type, ?array $collection = null)
    {
        $this->coordinates = new CoordinateCollection();
        parent::__construct($collection);
        $this->type = $type;
    }

    public function setCoordinates(PointCollection $points)
    {
        if ($this->type === self::POINT) {
            $point = $points->first();
            $this->addCoordinate(...$point->getCoordinates());
        } else {
            $coordinates = $points->getCoordinates();
            $this->coordinates->fill($coordinates);
        }

        return $this;
    }

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
