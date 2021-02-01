<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Types\Point;

class WaypointParser
{
    /**
     * Parses waypoint data.
     * @param \SimpleXMLElement[] $nodes
     * @return Point[]
     */
    public function parse($nodes) : array
    {
        $waypoints = [];

        foreach ($nodes as $node) {
            $waypoints []= PointParser::parse($node);
        }

        return $waypoints;
    }

    /**
     * XML representation of waypoint data.
     * @param Point $wpt
     * @param \DOMDocument $doc
     * @return \DOMNode
     */
    public static function toXML(Point $wpt, \DOMDocument $doc) : \DOMNode
    {
        $node = PointParser::toXML($wpt, Point::WAYPOINT, $doc);

        return $node;
    }
}
