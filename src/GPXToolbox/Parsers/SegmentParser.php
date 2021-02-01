<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Types\Segment;
use GPXToolbox\Types\Point;

class SegmentParser
{
    /**
     * Parses segment data.
     * @param \SimpleXMLElement[] $nodes
     * @return Segment[]
     */
    public function parse($nodes) : array
    {
        $segments = [];

        foreach ($nodes as $node) {
            $segment = new Segment();

            if (isset($node->trkpt)) {
                $segment->points = [];
                
                foreach ($node->trkpt as $point) {
                    $segment->points []= PointParser::parse($point);
                }
            }

            $segments []= $segment;
        }

        return $segments;
    }

    /**
     * XML representation of segment data.
     * @param Segment $segment
     * @param \DOMDocument $doc
     * @return \DOMNode
     */
    public static function toXML(Segment $segment, \DOMDocument $doc) : \DOMNode
    {
        $node = $doc->createElement('trkseg');

        if (!empty($segment->points)) {
            foreach ($segment->points as $point) {
                $node->appendChild(PointParser::toXML($point, Point::TRACKPOINT, $doc));
            }
        }

        return $node;
    }

    /**
     * XML representation of array segment data.
     * @param Segment[] $segments
     * @param \DOMDocument $doc
     * @return \DOMNode[]
     */
    public static function toXMLArray(array $segments, \DOMDocument $doc) : array
    {
        $result = [];

        foreach ($segments as $segment) {
            $result []= self::toXML($segment, $doc);
        }

        return $result;
    }
}
