<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Xml;
use GPXToolbox\GPXToolbox;
use GPXToolbox\Traits\Gpx\HasLinks;

class Point extends Xml
{
    use HasLinks;

    public const WAYPOINT = 'wpt';
    public const TRACKPOINT = 'trkpt';
    public const ROUTEPOINT = 'rtept';

    protected ?array $attributes = ['lat', 'lon',];

    protected string $type = '';

    public float $lat = 0.0;

    public float $lon = 0.0;

    public ?float $ele = null;

    public ?Datetime $time = null;

    public ?float $magvar = null;

    public ?float $geoidheight = null;

    public ?string $name = null;

    public ?string $cmt = null;

    public ?string $desc = null;

    public ?string $src = null;

    public LinkCollection $link;

    public ?string $sym = null;

    public ?string $fix = null;

    public ?int $sat = null;

    public ?float $hdop = null;

    public ?float $vdop = null;

    public ?float $pdop = null;

    public ?float $ageofdgpsdata = null;

    public ?int $dgpsid = null;

    public function __construct(?array $collection = null)
    {
        $this->link = new LinkCollection();
        parent::__construct($collection);
    }

    public function setLat(float $value)
    {
        $this->lat = round((float) $value, GPXToolbox::getConfiguration()->getCoordinatePrecision());

        return $this;
    }

    public function getLat(): float
    {
        return $this->lat;
    }

    public function setLon(float $value)
    {
        $this->lon = round((float) $value, GPXToolbox::getConfiguration()->getCoordinatePrecision());

        return $this;
    }

    public function getLon(): float
    {
        return $this->lon;
    }

    public function setLatitude(float $value)
    {
        return $this->setLat($value);
    }

    public function getLatitude(): float
    {
        return $this->getLat();
    }

    public function setLongitude(float $value)
    {
        return $this->setLat($value);
    }

    public function getLongitude(): float
    {
        return $this->getLon();
    }

    public function setX(float $value)
    {
        return $this->setLat($value);
    }

    public function getX(): float
    {
        return $this->getLat();
    }

    public function setY(float $value)
    {
        return $this->setLon($value);
    }

    public function getY(): float
    {
        return $this->getLon();
    }

    public function getCoordinates(): array
    {
        return [$this->getLongitude(), $this->getLatitude(),];
    }

    public function setEle(float $value)
    {
        $this->ele = round((float) $value, GPXToolbox::getConfiguration()->getElevationPrecision());

        return $this;
    }

    public function getEle(): float
    {
        return $this->ele;
    }

    public function setElevation(float $value)
    {
        return $this->setEle($value);
    }

    public function getElevation(): float
    {
        return $this->getEle();
    }

    public function setZ(float $value)
    {
        return $this->setLat($value);
    }

    public function getZ(): float
    {
        return $this->getLat();
    }

    public function getProperties(): array
    {
        $properties = self::unwrapAttributes($this->toArray());

        $excludedKeys = ['lat', 'lon',];
        $properties = array_diff_key($properties, array_flip($excludedKeys));

        return $properties;
    }
}
