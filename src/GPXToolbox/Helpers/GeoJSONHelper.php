<?php

namespace GPXToolbox\Helpers;

use GPXToolbox\Models\GeoJSON\Collection;
use GPXToolbox\Models\GeoJSON\Feature;
use GPXToolbox\Models\GeoJSON\Geometry;
use GPXToolbox\Types\GPX;
use GPXToolbox\Types\Point;
use GPXToolbox\Types\Route;
use GPXToolbox\Types\Track;

class GeoJSONHelper
{
    /**
     * Create GeoJSON collection.
     * @param GPX $gpx
     * @return Collection
     */
    public static function createCollection(GPX $gpx): Collection
    {
        $collection = new Collection();

        if (!empty($gpx->wpt)) {
            foreach ($gpx->wpt as $wpt) {
                $collection->addFeature(self::createWaypointFeature($wpt));
            }
        }

        if (!empty($gpx->rte)) {
            foreach ($gpx->rte as $rte) {
                $collection->addFeature(self::createRouteFeature($rte));
            }
        }

        if (!empty($gpx->trk)) {
            foreach ($gpx->trk as $trk) {
                $collection->addFeature(self::createTrackFeature($trk));
            }
        }

        return $collection;
    }

    /**
     * Create GeoJSON waypoint feature.
     * @param Point $wpt
     * @return Feature
     */
    public static function createWaypointFeature(Point $wpt): Feature
    {
        $feature = new Feature(Geometry::POINT);

        array_push($feature->geometry->coordinates, $wpt->lon, $wpt->lat);

        $properties = array_diff_key($wpt->toArray(), array_flip(['lat', 'lon',]));
        $feature->properties = $properties;

        return $feature;
    }

    /**
     * Create GeoJSON route feature.
     * @param Route $rte
     * @return Feature
     */
    public static function createRouteFeature(Route $rte): Feature
    {
        $feature = new Feature(Geometry::LINE_STRING);

        if (!empty($rte->points)) {
            foreach ($rte->points as $rtept) {
                $feature->geometry->addCoordinates($rtept->lon, $rtept->lat);
            }
        }

        $properties = array_diff_key($rte->toArray(), array_flip(['points',]));
        $feature->properties = $properties;

        return $feature;
    }

    /**
     * Create GeoJSON track feature.
     * @param Track $trk
     * @return Feature
     */
    public static function createTrackFeature(Track $trk): Feature
    {
        $feature = new Feature(Geometry::LINE_STRING);

        if (!is_null($trk->trkseg)) {
            foreach ($trk->trkseg as $trkseg) {
                if (empty($trkseg->points)) {
                    continue;
                }

                foreach ($trkseg->points as $trkpt) {
                    $feature->geometry->addCoordinates($trkpt->lon, $trkpt->lat);
                }
            }
        }

        $properties = array_diff_key($trk->toArray(), array_flip(['trkseg',]));
        $feature->properties = $properties;

        return $feature;
    }
}
