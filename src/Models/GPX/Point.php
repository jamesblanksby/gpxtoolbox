<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Xml;
use GPXToolbox\Traits\Gpx\HasLinks;

final class Point extends Xml
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

    public function getLatitude(): float
    {
        return $this->lat;
    }

    public function getLongitude(): float
    {
        return $this->lon;
    }

    public function getCoordinates(): array
    {
        return [$this->getLongitude(), $this->getLatitude(),];
    }

    public function getElevation(): float
    {
        return $this->ele;
    }

    public function getProperties(): array
    {
        $properties = self::unwrapAttributes($this->toArray());

        $excludedKeys = ['lat', 'lon',];
        $properties = array_diff_key($properties, array_flip($excludedKeys));

        return $properties;
    }
}
