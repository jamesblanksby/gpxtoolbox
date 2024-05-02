<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Xml;
use GPXToolbox\GPXToolbox;
use GPXToolbox\Traits\Gpx\HasLinks;

class Point extends Xml
{
    use HasLinks;

    /**
     * @inheritDoc
     */
    protected ?array $attributes = ['lat', 'lon',];

    /**
     * Latitude of the point.
     *
     * @var float
     */
    public float $lat = 0.0;

    /**
     * Longitude of the point.
     *
     * @var float
     */
    public float $lon = 0.0;

    /**
     * Elevation of the point.
     *
     * @var float|null
     */
    public ?float $ele = null;

    /**
     * Time associated with the point.
     *
     * @var Datetime|null
     */
    public ?Datetime $time = null;

    /**
     * Magnetic variation of the point.
     *
     * @var float|null
     */
    public ?float $magvar = null;

    /**
     * Geoid height of the point.
     *
     * @var float|null
     */
    public ?float $geoidheight = null;

    /**
     * Name of the point.
     *
     * @var string|null
     */
    public ?string $name = null;

    /**
     * Comment associated with the point.
     *
     * @var string|null
     */
    public ?string $cmt = null;

    /**
     * Description of the point.
     *
     * @var string|null
     */
    public ?string $desc = null;

    /**
     * Source of the point.
     *
     * @var string|null
     */
    public ?string $src = null;

    /**
     * Link collection associated with the point.
     *
     * @var LinkCollection
     */
    public LinkCollection $link;

    /**
     * Symbol associated with the point.
     *
     * @var string|null
     */
    public ?string $sym = null;

    /**
     * Fix status of the point.
     *
     * @var string|null
     */
    public ?string $fix = null;

    /**
     * Number of satellites associated with the point.
     *
     * @var int|null
     */
    public ?int $sat = null;

    /**
     * Horizontal dilution of precision.
     *
     * @var float|null
     */
    public ?float $hdop = null;

    /**
     * Vertical dilution of precision.
     *
     * @var float|null
     */
    public ?float $vdop = null;

    /**
     * Position dilution of precision.
     *
     * @var float|null
     */
    public ?float $pdop = null;

    /**
     * Age of differential GPS data.
     *
     * @var float|null
     */
    public ?float $ageofdgpsdata = null;

    /**
     * ID of differential GPS station.
     *
     * @var int|null
     */
    public ?int $dgpsid = null;

    /**
     * Point constructor.
     *
     * @param array|null $collection
     */
    public function __construct(?array $collection = null)
    {
        $this->link = new LinkCollection();
        parent::__construct($collection);
    }

    /**
     * Set the latitude of the point.
     *
     * @param float $value
     * @return $this
     */
    public function setLat(float $value)
    {
        $this->lat = round((float) $value, GPXToolbox::getConfiguration()->coordinatePrecision);

        return $this;
    }

    /**
     * Get the latitude of the point.
     *
     * @return float
     */
    public function getLat(): float
    {
        return $this->lat;
    }

    /**
     * Set the longitude of the point.
     *
     * @param float $value
     * @return $this
     */
    public function setLon(float $value)
    {
        $this->lon = round((float) $value, GPXToolbox::getConfiguration()->coordinatePrecision);

        return $this;
    }

    /**
     * Get the longitude of the point.
     *
     * @return float
     */
    public function getLon(): float
    {
        return $this->lon;
    }

    /**
     * Alias for setLat
     *
     * @param float $value
     * @return $this
     */
    public function setLatitude(float $value)
    {
        return $this->setLat($value);
    }

    /**
     * Alias for getLat
     *
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->getLat();
    }

    /**
     * Alias for setLon
     *
     * @param float $value
     * @return $this
     */
    public function setLongitude(float $value)
    {
        return $this->setLon($value);
    }

    /**
     * Alias for getLat
     *
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->getLon();
    }

    /**
     * Get the coordinates of the point as an array.
     *
     * @return array
     */
    public function getCoordinates(): array
    {
        return [$this->getLon(), $this->getLat(),];
    }

    /**
     * Alias for setLat
     *
     * @param float $value
     * @return $this
     */
    public function setX(float $value)
    {
        return $this->setLat($value);
    }

    /**
     * Alias for getLat
     *
     * @return float
     */
    public function getX(): float
    {
        return $this->getLat();
    }

    /**
     * Alias for setLon
     *
     * @param float $value
     * @return $this
     */
    public function setY(float $value)
    {
        return $this->setLon($value);
    }

    /**
     * Alias for getLon
     *
     * @return float
     */
    public function getY(): float
    {
        return $this->getLon();
    }

    /**
     * Set the elevation of the point.
     *
     * @param float|null $value
     * @return $this
     */
    public function setEle(?float $value)
    {
        $this->ele = round((float) $value, GPXToolbox::getConfiguration()->elevationPrecision);

        return $this;
    }

    /**
     * Get the elevation of the point.
     *
     * @return float|null
     */
    public function getEle(): ?float
    {
        return $this->ele;
    }

    /**
     * Alias for setEle
     *
     * @param float|null $value
     * @return $this
     */
    public function setElevation(?float $value)
    {
        return $this->setEle($value);
    }

    /**
     * Alias for getEle
     *
     * @return float|null
     */
    public function getElevation(): ?float
    {
        return $this->getEle();
    }

    /**
     * Alias for getEle
     *
     * @param float|null $value
     * @return $this
     */
    public function setZ(?float $value)
    {
        return $this->setEle($value);
    }

    /**
     * Alias for getEle
     *
     * @return float|null
     */
    public function getZ(): ?float
    {
        return $this->getEle();
    }

    /**
     * Get the properties of the point (excluding lat and lon).
     *
     * @return array
     */
    public function getProperties(): array
    {
        $properties = self::unwrapAttributes($this->toArray());

        $excludedKeys = ['lat', 'lon',];
        $properties = array_diff_key($properties, array_flip($excludedKeys));

        return $properties;
    }
}
