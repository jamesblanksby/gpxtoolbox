<?php

namespace GPXToolbox\Serializers\GPX;

use GPXToolbox\Models\GPX\WaypointCollection;
use SimpleXMLElement;

final class WaypointSerializer extends PointSerializer
{
    /**
     * Serialize waypoint from a SimpleXMLElement.
     *
     * @param SimpleXMLElement $nodes
     * @return WaypointCollection
     */
    public static function serialize(SimpleXMLElement $nodes): WaypointCollection
    {
        return new WaypointCollection(parent::serialize($nodes));
    }
}
