<?php

namespace GPXToolbox\Types;

use GPXToolbox\Helpers\DateTimeHelper;
use GPXToolbox\Helpers\SerializationHelper;

class Point
{
    /**
    * Waypoint GPX key.
    * @var string
    */
    const WAYPOINT = 'wpt';

    /**
     * Trackpoint GPX key.
     * @var string
     */
    const TRACKPOINT = 'trkpt';
    
    /**
     * Routepoint GPX key.
     * @var string
     */
    const ROUTEPOINT = 'rte';
    
    /**
     * The latitude of the point. Decimal degrees, WGS84 datum.
     * @var float
     */
    public $lat = 0.0;

    /**
     * The longitude of the point. Decimal degrees, WGS84 datum.
     * @var float
     */
    public $lon = 0.0;

    /**
     * Elevation (in meters) of the point.
     * @var float|null
     */
    public $ele = 0.0;

    /**
     * Creation/modification timestamp for element.
     * @var \Datetime|null
     */
    public $time = null;

    /**
     * Magnetic variation (in degrees) at the point.
     * @var float|null
     */
    public $magvar = null;

    /**
     * Height (in meters) of geoid (mean sea level) above WGS84 earth ellipsoid.
     * @var float|null
     */
    public $geoidheight = null;

    /**
     * The GPS name of the point.
     * @var string|null
     */
    public $name = null;

    /**
     * GPS waypoint comment.
     * @var string|null
     */
    public $cmt = null;

    /**
     * A text description of the element.
     * @var string|null
     */
    public $desc = null;

    /**
     * Source of data.
     * Included to give user some idea of reliability and accuracy of data
     * @var string|null
     */
    public $src = null;

    /**
     * Link to additional information about the point.
     * @var Link[]|null
     */
    public $links = null;

    /**
     * Text of GPS symbol name.
     * @var string|null
     */
    public $sym = null;

    /**
     * Type of GPX fix.
     * @var string|null
     */
    public $fix = null;

    /**
     * Number of satellites used to calculate the GPX fix.
     * @var int|null
     */
    public $sat = null;

    /**
     * Horizontal dilution of precision.
     * @var float|null
     */
    public $hdop = null;

    /**
     * Vertical dilution of precision.
     * @var float|null
     */
    public $vdop = null;

    /**
     * Position dilution of precision.
     * @var float|null
     */
    public $pdop = null;

    /**
     * Number of seconds since last DGPS update.
     * @var float|null
     */
    public $ageofdgpsdata = null;

    /**
     * ID of DGPS station used in differential correction.
     * @var int|null
     */
    public $dgpsid = null;

    /**
     * Array representation of point data.
     * @return array
     */
    public function toArray() : array
    {
        return [
            'lat'           => $this->lat,
            'lon'           => $this->lon,
            'ele'           => $this->ele,
            'time'          => DateTimeHelper::format($this->time),
            'magvar'        => $this->magvar,
            'name'          => $this->name,
            'cmt'           => $this->cmt,
            'desc'          => $this->desc,
            'src'           => $this->src,
            'links'         => SerializationHelper::toArray($this->links),
            'sym'           => $this->sym,
            'fix'           => $this->fix,
            'sat'           => $this->sat,
            'hdop'          => $this->hdop,
            'vdop'          => $this->vdop,
            'pdop'          => $this->pdop,
            'ageofdgpsdata' => $this->ageofdgpsdata,
            'dgpsid'        => $this->dgpsid,
        ];
    }
}
