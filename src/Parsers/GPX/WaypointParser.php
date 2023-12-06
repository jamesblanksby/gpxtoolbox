<?php

namespace GPXToolbox\Parsers\GPX;

use GPXToolbox\Models\GPX\WaypointCollection;
use SimpleXMLElement;

final class WaypointParser extends PointParser
{
    /**
     * Parse waypoint from a SimpleXMLElement.
     *
     * @param SimpleXMLElement $nodes
     * @return WaypointCollection
     */
    public static function parse(SimpleXMLElement $nodes): WaypointCollection
    {
        return new WaypointCollection(parent::parse($nodes));
    }
}
