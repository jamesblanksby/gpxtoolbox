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

final class GeoJsonSerializer
{
    public static function serialize(Gpx $gpx): FeatureCollection
    {
        $features = new FeatureCollection();

        $features = self::serializeWaypoints($features, $gpx->getWaypoints());
        $features = self::serializeRoutes($features, $gpx->getRoutes());
        $features = self::serializeTracks($features, $gpx->getTracks());

        return $features;
    }

    protected static function serializeWaypoints(FeatureCollection $features, WaypointCollection $waypoints): FeatureCollection
    {
        foreach ($waypoints->all() as $point) {
            $properties = array_diff_key($point->toArray(), array_flip(['lat', 'lon',]));
            $feature = self::serializeFeature(Geometry::POINT, new PointCollection($point), $properties);

            $features->addFeature($feature);
        }

        return $features;
    }

    protected static function serializeRoutes(FeatureCollection $features, RouteCollection $routes): FeatureCollection
    {
        foreach ($routes->all() as $route) {
            $properties = array_diff_key($route->toArray(), array_flip(['rtept',]));
            $feature = self::serializeFeature(Geometry::LINE_STRING, $route->getPoints(), $properties);

            $features->addFeature($feature);
        }

        return $features;
    }

    protected static function serializeTracks(FeatureCollection $features, TrackCollection $tracks): FeatureCollection
    {
        foreach ($tracks->all() as $track) {
            $properties = array_diff_key($track->toArray(), array_flip(['trkseg',]));
            $feature = self::serializeFeature(Geometry::LINE_STRING, $track->getPoints(), $properties);

            $features->addFeature($feature);
        }

        return $features;
    }

    protected static function serializeFeature(string $geometry, PointCollection $points, array $properties): Feature
    {
        $feature = new Feature($geometry);

        $feature->getGeometry()->setCoordinates($points);
        $feature->setProperties(array_filter($properties));

        return $feature;
    }
}
