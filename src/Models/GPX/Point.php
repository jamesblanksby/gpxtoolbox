<?php

namespace GPXToolbox\Models\GPX;

use GPXToolbox\Abstracts\GPX\GPXType;
use GPXToolbox\Traits\GPX\HasLinks;
use DateTime;

class Point extends GPXType
{
    use HasLinks;

    /**
     * The GPX point types.
     */
    public const WAYPOINT = 'wpt';
    public const TRACKPOINT = 'trkpt';
    public const ROUTEPOINT = 'rtept';

    /**
     * The type of the point.
     *
     * @var string
     */
    protected $type = '';

    /**
     * @var float The latitude of the point.
     */
    public $lat = 0.0;

    /**
     * @var float The longitude of the point.
     */
    public $lon = 0.0;

    /**
     * @var float The elevation of the point.
     */
    public $ele = 0.0;

    /**
     * @var Datetime|null The timestamp associated with the point.
     */
    public $time = null;

    /**
     * @var float|null The magnetic variation at the point.
     */
    public $magvar = null;

    /**
     * @var float|null The geoid height at the point.
     */
    public $geoidheight = null;

    /**
     * @var string|null The name associated with the point.
     */
    public $name = null;

    /**
     * @var string|null The comment associated with the point.
     */
    public $cmt = null;

    /**
     * @var string|null The description associated with the point.
     */
    public $desc = null;

    /**
     * @var string|null The source of the point's information.
     */
    public $src = null;

    /**
     * @var LinkCollection A list of links associated with the point.
     */
    public $link;

    /**
     * @var string|null The symbol associated with the point.
     */
    public $sym = null;

    /**
     * @var string|null The fix status of the point.
     */
    public $fix = null;

    /**
     * @var int|null The number of satellites used to calculate the point's position.
     */
    public $sat = null;

    /**
     * @var float|null The horizontal dilution of precision at the point.
     */
    public $hdop = null;

    /**
     * @var float|null The vertical dilution of precision at the point.
     */
    public $vdop = null;

    /**
     * @var float|null The position dilution of precision at the point.
     */
    public $pdop = null;

    /**
     * @var float|null The age of the differential GPS data at the point.
    */
    public $ageofdgpsdata = null;

    /**
     * @var int|null The ID of the differential GPS station used to calculate the point's position.
     */
    public $dgpsid = null;

    /**
     * Point constructor.
     *
     * @param string $type
     * @param array|null $collection
     */
    public function __construct(string $type, ?array $collection = null)
    {
        $this->link = new LinkCollection();
        parent::__construct($collection);
        $this->type = $type;
    }

    /**
     * Get the latitude value of the point.
     *
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->lat;
    }

    /**
     * Get the longitude value of the point.
     *
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->lon;
    }

    /**
     * Get a the coordinates of the point.
     *
     * @return array
     */
    public function getCoordinates(): array
    {
        return [$this->getLongitude(), $this->getLatitude(),];
    }

    /**
     * Get the elevation value of the point.
     *
     * @return float
     */
    public function getElevation(): float
    {
        return $this->ele;
    }
}
