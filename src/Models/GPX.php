<?php

namespace GPXToolbox\Models;

use GPXToolbox\Abstracts\Xml;
use GPXToolbox\GPXToolbox;
use GPXToolbox\Models\Gpx\Metadata;
use GPXToolbox\Models\Gpx\Point;
use GPXToolbox\Models\Gpx\Route;
use GPXToolbox\Models\Gpx\RouteCollection;
use GPXToolbox\Models\Gpx\Track;
use GPXToolbox\Models\Gpx\TrackCollection;
use GPXToolbox\Models\Gpx\WaypointCollection;
use GPXToolbox\Serializers\Gpx\GeoJsonSerializer;
use GPXToolbox\Serializers\XmlSerializer;

final class Gpx extends Xml
{
    protected ?array $attributes = ['version', 'creator',];

    public string $version = '1.1';

    public string $creator = GPXToolbox::SIGNATURE;

    public ?Metadata $metadata = null;

    public WaypointCollection $wpt;

    public RouteCollection $rte;

    public TrackCollection $trk;

    public function __construct($collection = null)
    {
        $this->wpt = new WaypointCollection();
        $this->rte = new RouteCollection();
        $this->trk = new TrackCollection();
        parent::__construct($collection);
    }

    public function addWaypoint(Point $waypoint)
    {
        $this->getWaypoints()->add($waypoint);

        return $this;
    }

    public function getWaypoints()
    {
        return $this->wpt;
    }

    public function addRoute(Route $route)
    {
        $this->getRoutes()->add($route);

        return $this;
    }

    public function getRoutes()
    {
        return $this->rte;
    }

    public function addTrack(Track $track)
    {
        $this->getTracks()->add($track);

        return $this;
    }

    public function getTracks()
    {
        return $this->trk;
    }

    public function toXml(): string
    {
        return $this->serializeXml()->saveXML();
    }

    public function serializeXml(): \DOMDocument
    {
        $doc = new \DOMDocument();

        $doc->appendChild(XmlSerializer::serialize($doc, 'gpx', $this->toArray()));

        $doc->createAttributeNS('http://www.topografix.com/GPX/1/1', 'xmlns');
    
        return $doc;
    }

    public function toGeoJson(int $options = 0): string
    {
        return json_encode($this->serializeGeoJson(), $options);
    }

    public function serializeGeoJson(): array
    {
        $features = GeoJsonSerializer::serialize($this);

        return $features->toArray();
    }
}
