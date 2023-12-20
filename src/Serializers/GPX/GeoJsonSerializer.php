<?php

namespace GPXToolbox\Serializers\Gpx;

use GPXToolbox\Models\GeoJson\Feature;
use GPXToolbox\Models\GeoJson\FeatureCollection;
use GPXToolbox\Models\GeoJson\Geometry;
use GPXToolbox\Models\Gpx;
use GPXToolbox\Models\Gpx\PointCollection;
use GPXToolbox\Models\Gpx\RouteCollection;
use GPXToolbox\Models\Gpx\TrackCollection;
use GPXToolbox\Models\Gpx\WaypointCollection;

class GeoJsonSerializer
{
    /**
     * Serialize GPX data to GeoJSON format.
     *
     * @param Gpx $gpx
     * @return FeatureCollection
     */
    public static function serialize(Gpx $gpx): FeatureCollection
    {
        $features = new FeatureCollection();

        $features = self::serializeWaypoints($features, $gpx->getWaypoints());
        $features = self::serializeRoutes($features, $gpx->getRoutes());
        $features = self::serializeTracks($features, $gpx->getTracks());

        return $features;
    }

    /**
     * Serialize waypoints to GeoJSON features.
     *
     * @param FeatureCollection $features
     * @param WaypointCollection $waypoints
     * @return FeatureCollection
     */
    protected static function serializeWaypoints(FeatureCollection $features, WaypointCollection $waypoints): FeatureCollection
    {
        foreach ($waypoints->all() as $point) {
            $feature = self::serializeFeature(Geometry::POINT, new PointCollection($point), $point->getProperties());

            $features->addFeature($feature);
        }

        return $features;
    }

    /**
     * Serialize routes to GeoJSON features.
     *
     * @param FeatureCollection $features
     * @param RouteCollection $routes
     * @return FeatureCollection
     */
    protected static function serializeRoutes(FeatureCollection $features, RouteCollection $routes): FeatureCollection
    {
        foreach ($routes->all() as $route) {
            $feature = self::serializeFeature(Geometry::LINE_STRING, $route->getPoints(), $route->getProperties());

            $features->addFeature($feature);
        }

        return $features;
    }

    /**
     * Serialize tracks to GeoJSON features.
     *
     * @param FeatureCollection $features
     * @param TrackCollection $tracks
     * @return FeatureCollection
     */
    protected static function serializeTracks(FeatureCollection $features, TrackCollection $tracks): FeatureCollection
    {
        foreach ($tracks->all() as $track) {
            $feature = self::serializeFeature(Geometry::LINE_STRING, $track->getPoints(), $track->getProperties());

            $features->addFeature($feature);
        }

        return $features;
    }

    /**
     * Serialize a GeoJSON feature.
     *
     * @param string $geometry
     * @param PointCollection $points
     * @param array $properties
     * @return Feature
     */
    protected static function serializeFeature(string $geometry, PointCollection $points, array $properties): Feature
    {
        $feature = new Feature($geometry);

        $feature->getGeometry()->setCoordinates($points);
        $feature->setProperties(array_filter($properties));

        return $feature;
    }
}
