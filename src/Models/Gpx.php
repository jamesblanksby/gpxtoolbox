<?php

namespace GPXToolbox\Models;

use GPXToolbox\Abstracts\Xml;
use GPXToolbox\GPXToolbox;
use GPXToolbox\Models\Gpx\Metadata;
use GPXToolbox\Models\Gpx\Point;
use GPXToolbox\Models\Gpx\PointCollection;
use GPXToolbox\Models\Gpx\Route;
use GPXToolbox\Models\Gpx\RouteCollection;
use GPXToolbox\Models\Gpx\Track;
use GPXToolbox\Models\Gpx\TrackCollection;
use GPXToolbox\Serializers\Gpx\GeoJsonSerializer;
use GPXToolbox\Serializers\XmlSerializer;

class Gpx extends Xml
{
    /**
     * @inheritDoc
     */
    protected ?array $attributes = ['version', 'creator',];

    /**
     * GPX version.
     *
     * @var string
     */
    public string $version = '1.1';

    /**
     * Application or tool that created the GPX file.
     *
     * @var string
     */
    public string $creator = GPXToolbox::SIGNATURE;

    /**
     * Metadata information for the GPX file.
     *
     * @var Metadata|null
     */
    public ?Metadata $metadata = null;

    /**
     * A collection of points in the GPX file.
     *
     * @var PointCollection
     */
    public PointCollection $wpt;

    /**
     * A collection of routes in the GPX file.
     *
     * @var RouteCollection
     */
    public RouteCollection $rte;

    /**
     * A collection of tracks in the GPX file.
     *
     * @var TrackCollection
     */
    public TrackCollection $trk;

    /**
     * Gpx constructor.
     *
     * @param mixed|null $collection
     */
    public function __construct($collection = null)
    {
        $this->wpt = new PointCollection();
        $this->rte = new RouteCollection();
        $this->trk = new TrackCollection();
        parent::__construct($collection);
    }

    /**
     * Add a Point to the GPX file.
     *
     * @param Point $Point
     * @return $this
     */
    public function addPoint(Point $Point)
    {
        $this->getPoints()->add($Point);

        return $this;
    }

    /**
     * Get the collection of points associated with the GPX file.
     *
     * @return PointCollection
     */
    public function getPoints()
    {
        return $this->wpt;
    }

    /**
     * Add a route to the GPX file.
     *
     * @param Route $route
     * @return $this
     */
    public function addRoute(Route $route)
    {
        $this->getRoutes()->add($route);

        return $this;
    }

    /**
     * Get the collection of routes associated with the GPX file.
     *
     * @return RouteCollection
     */
    public function getRoutes()
    {
        return $this->rte;
    }

    /**
     * Add a track to the GPX file.
     *
     * @param Track $track
     * @return $this
     */
    public function addTrack(Track $track)
    {
        $this->getTracks()->add($track);

        return $this;
    }

    /**
     * Get the collection of tracks associated with the GPX file.
     *
     * @return TrackCollection
     */
    public function getTracks()
    {
        return $this->trk;
    }

    /**
     * Convert the GPX data to an XML string.
     *
     * @return string
     */
    public function toXml(): string
    {
        return $this->serializeXml()->saveXML();
    }

    /**
     * Serialize the GPX data to XML.
     *
     * @return \DOMDocument
     */
    public function serializeXml(): \DOMDocument
    {
        $doc = new \DOMDocument();

        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = true;

        $doc->appendChild(XmlSerializer::serialize($doc, 'gpx', $this->toXmlArray()));

        $doc->createAttributeNS('http://www.topografix.com/GPX/1/1', 'xmlns');

        return $doc;
    }

    /**
     * Convert the GPX data to GeoJSON format.
     *
     * @param int $options
     * @return string
     */
    public function toGeoJson(int $options = 0): string
    {
        return json_encode($this->serializeGeoJson(), $options);
    }

    /**
     * Serialize the GPX data to GeoJSON.
     *
     * @return array
     */
    public function serializeGeoJson(): array
    {
        $features = GeoJsonSerializer::serialize($this);

        return $features->toArray();
    }
}
