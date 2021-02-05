<?php

namespace GPXToolbox\Models\GeoJSON;

class Geometry
{
    /**
     * @var string
     */
    const POINT = 'Point';

    /**
     * @var string
     */
    const LINE_STRING = 'LineString';

    /**
     * @var string
     */
    const POLYGON = 'Polygon';

    /**
     * @var string
     */
    const MULTI_POINT = 'MultiPoint';

    /**
     * @var string
     */
    const MULTI_LINE_STRING = 'MultiLineString';

    /**
     * @var string
     */
    const MULTI_POLYGON = 'MultiPolygon';

    /**
     * @var string
     */
    const GEOMETRY_COLLECTION = 'GeometryCollection';

    /**
     * Geometry type.
     * @var string
     */
    public $type = '';

    /**
     * A list of coordinates.
     * @var array
     */
    public $coordinates = [];

    /**
     * Geometry constructor.
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * Add coordinates to geometry.
     * @param float $lon
     * @param float $lat
     * @return boolean
     */
    public function addCoordinates(float $lon, float $lat) : bool
    {
        return array_push($this->coordinates, [$lon, $lat,]);
    }
}
