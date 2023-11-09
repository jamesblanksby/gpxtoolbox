<?php

namespace GPXToolbox\Models;

use GPXToolbox\Abstracts\GPX\GPXType;
use GPXToolbox\GPXToolbox;
use GPXToolbox\Models\GeoJSON;
use GPXToolbox\Models\GeoJSON\Feature;
use GPXToolbox\Models\GeoJSON\Geometry;
use GPXToolbox\Models\GPX\Metadata;
use GPXToolbox\Models\GPX\Point;
use GPXToolbox\Models\GPX\Route;
use GPXToolbox\Models\GPX\RouteCollection;
use GPXToolbox\Models\GPX\Track;
use GPXToolbox\Models\GPX\TrackCollection;
use GPXToolbox\Models\GPX\WaypointCollection;

class GPX extends GPXType
{
    /**
     * @var string The version of the GPX file.
     */
    public $version = '1.1';

    /**
     * @var string The creator of the GPX file.
     */
    public $creator = GPXToolbox::SIGNATURE;

    /**
     * @var Metadata|null Additional metadata associated with the GPX file.
     */
    public $metadata = null;

    /**
     * @var WaypointCollection A list of GPX waypoints.
     */
    public $wpt;

    /**
     * @var RouteCollection A list of GPX routes.
     */
    public $rte;

    /**
     * @var TrackCollection A list of GPX tracks.
     */
    public $trk;

    /**
     * GPX constructor.
     *
     * @param array|null $collection
     */
    public function __construct($collection = null)
    {
        $this->wpt = new WaypointCollection();
        $this->rte = new RouteCollection();
        $this->trk = new TrackCollection();
        parent::__construct($collection);
    }

    /**
     * Add a waypoint to the GPX file.
     *
     * @param Point $waypoint
     * @return $this
     */
    public function addWaypoint(Point $waypoint)
    {
        $this->getWaypoints()->add($waypoint);

        return $this;
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
     * Get the waypoints from GPX file.
     *
     * @return WaypointCollection
     */
    public function getWaypoints()
    {
        return $this->wpt;
    }

    /**
     * Get the routes from GPX file.
     *
     * @return RouteCollection
     */
    public function getRoutes()
    {
        return $this->rte;
    }

    /**
     * Get the tracks from GPX file.
     *
     * @return TrackCollection
     */
    public function getTracks()
    {
        return $this->trk;
    }

    /**
     * Convert the GPX object to GeoJSON.
     *
     * @param int $options
     * @return string
     */
    public function toGeoJson(int $options = 0)
    {
        return json_encode($this->serializeGeoJson(), $options);
    }

    /**
     * Serialize the GPX attributes for GeoJSON.
     *
     * @return array
     */
    public function serializeGeoJson(): array
    {
        $geojson = new GeoJSON();

        foreach ($this->getWaypoints() as $point) {
            $feature = new Feature(Geometry::POINT);
            $feature->getGeometry()->addCoordinate($point->getLongitude(), $point->getLatitude());

            $properties = array_diff_key($point->toArray(), array_flip(['lat', 'lon',]));
            $feature->setProperties($properties);

            $geojson->addFeature($feature);
        }

        foreach ($this->getRoutes() as $route) {
            $feature = new Feature(Geometry::LINE_STRING);
            foreach ($route->getPoints() as $point) {
                $feature->getGeometry()->addCoordinate($point->getLongitude(), $point->getLatitude());
            }

            $properties = array_diff_key($route->toArray(), array_flip(['rtept',]));
            $feature->setProperties($properties);

            $geojson->addFeature($feature);
        }

        foreach ($this->getTracks() as $track) {
            $feature = new Feature(Geometry::LINE_STRING);
            foreach ($track->getPoints() as $point) {
                $feature->getGeometry()->addCoordinate($point->getLongitude(), $point->getLatitude());
            }

            $properties = array_diff_key($track->toArray(), array_flip(['trkseg',]));
            $feature->setProperties($properties);

            $geojson->addFeature($feature);
        }

        return $geojson->toArray();
    }
}
