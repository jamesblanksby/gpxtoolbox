<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Types\Point;
use GPXToolbox\Types\Segment;
use DOMDocument;
use DOMNode;
use SimpleXMLElement;

class SegmentParser
{
    /**
     * Parses segment data.
     * @param SimpleXMLElement $nodes
     * @return Segment[]
     */
    public static function parse($nodes): array
    {
        $segments = [];

        foreach ($nodes as $node) {
            $segment = new Segment();

            $segment->points     = isset($node->trkpt) ? PointParser::parse($node->trkpt) : null;
            $segment->extensions = isset($node->extensions) ? ExtensionParser::parse($node->extensions) : null;

            $segments []= $segment;
        }

        return $segments;
    }

    /**
     * XML representation of segment data.
     * @param Segment $segment
     * @param DOMDocument $doc
     * @return DOMNode
     */
    public static function toXML(Segment $segment, DOMDocument $doc): DOMNode
    {
        $node = $doc->createElement('trkseg');

        if (!empty($segment->points)) {
            foreach ($segment->points as $trkpt) {
                $node->appendChild(PointParser::toXML($trkpt, Point::TRACKPOINT, $doc));
            }
        }

        if (!empty($segment->extensions)) {
            $child = $doc->createElement('extension');
            $node->appendChild($child);
            foreach ($segment->extensions as $extension) {
                $child->appendChild(ExtensionParser::toXML($extension, $doc));
            }
        }

        return $node;
    }

    /**
     * XML representation of array segment data.
     * @param Segment[] $segments
     * @param DOMDocument $doc
     * @return DOMNode[]
     */
    public static function toXMLArray(array $segments, DOMDocument $doc): array
    {
        $result = [];

        foreach ($segments as $segment) {
            $result []= self::toXML($segment, $doc);
        }

        return $result;
    }
}
