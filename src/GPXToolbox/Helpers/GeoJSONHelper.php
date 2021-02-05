<?php

namespace GPXToolbox\Helpers;

use GPXToolbox\Types\Point;
use GPXToolbox\Types\Route;
use GPXToolbox\Types\Track;
use GPXToolbox\Models\GeoJSON\Collection;
use GPXToolbox\Models\GeoJSON\Feature;
use GPXToolbox\Models\GeoJSON\Geometry;
use GPXToolbox\GPXToolbox;

class GeoJSONHelper
{
    /**
     * Create GeoJSON collection.
     * @param GPX $gpx
     * @return Collection
     */
    public static function createCollection($gpx) : Collection
    {
        $collection = new Collection();

        if (!empty($gpx->metadata)) {
            $collection->properties = $gpx->metadata->toArray();
        }

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
    public static function createWaypointFeature($wpt) : Feature
    {
        $feature = new Feature(Geometry::POINT);

        $feature->geometry->addCoordinates($wpt->lon, $wpt->lat);
        $feature->geometry->coordinates = $feature->geometry->coordinates[0];

        $properties = array_diff_key($wpt->toArray(), array_flip(['lat', 'lon',]));
        $feature->properties = $properties;

        return $feature;
    }

    /**
     * Create GeoJSON route feature.
     * @param Route $rte
     * @return Feature
     */
    public static function createRouteFeature($rte) : Feature
    {
        $feature = new Feature(Geometry::LINE_STRING);

        if (!is_null($rte->points)) {
            foreach ($rte->points as $point) {
                $feature->geometry->addCoordinates($point->lon, $point->lat);
            }
        }

        $properties = array_diff_key($trk->toArray(), array_flip(['points',]));
        $feature->properties = $properties;

        return $feature;
    }

    /**
     * Create GeoJSON track feature.
     * @param Track $trk
     * @return Feature
     */
    public static function createTrackFeature($trk) : Feature
    {
        $feature = new Feature(Geometry::LINE_STRING);

        if (!is_null($trk->trkseg)) {
            foreach ($trk->trkseg as $trkseg) {
                if (is_null($trkseg->points)) {
                    continue;
                }

                foreach ($trkseg->points as $point) {
                    $feature->geometry->addCoordinates($point->lon, $point->lat);
                }
            }
        }

        $properties = array_diff_key($trk->toArray(), array_flip(['trkseg',]));
        $feature->properties = $properties;

        return $feature;
    }
}
