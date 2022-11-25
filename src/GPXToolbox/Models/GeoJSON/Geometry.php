<?php

namespace GPXToolbox\Models\GeoJSON;

class Geometry
{
    /**
     * @var string
     */
    public const POINT = 'Point';

    /**
     * @var string
     */
    public const LINE_STRING = 'LineString';

    /**
     * @var string
     */
    public const POLYGON = 'Polygon';

    /**
     * @var string
     */
    public const MULTI_POINT = 'MultiPoint';

    /**
     * @var string
     */
    public const MULTI_LINE_STRING = 'MultiLineString';

    /**
     * @var string
     */
    public const MULTI_POLYGON = 'MultiPolygon';

    /**
     * @var string
     */
    public const GEOMETRY_COLLECTION = 'GeometryCollection';

    /**
     * Geometry type.
     * @var string
     */
    public $type = '';

    /**
     * A list of coordinates.
     * @var mixed[]
     */
    public $coordinates = [];

    /**
     * Geometry constructor.
     * @param string $type
     */
    public function __construct(string $type)
    {
        $this->type = $type;
    }

    /**
     * Add coordinates to geometry.
     * @param float $lon
     * @param float $lat
     * @return self
     */
    public function addCoordinates(float $lon, float $lat): self
    {
        array_push($this->coordinates, [$lon, $lat,]);

        return $this;
    }

    /**
     * Array representation of geometry data.
     * @return mixed[]
     */
    public function toArray(): array
    {
        return [
            'type'        => $this->type,
            'coordinates' => $this->coordinates,
        ];
    }
}
