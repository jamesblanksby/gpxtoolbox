<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Types\Segment;
use DOMDocument;
use DOMNode;
use SimpleXMLElement;

class SegmentParser
{
    /**
     * @var array<mixed>
     */
    private static $map = [
        'trkpt' => [
            'name' => 'points',
            'type' => 'element',
            'parser' => PointParser::class,
        ],
        'extensions' => [
            'name' => 'extensions',
            'type' => 'element',
            'parser' => PointParser::class,
        ],
    ];

    /**
     * Parses segment data.
     * @param SimpleXMLElement $nodes
     * @return array<int, Segment>
     */
    public static function parse($nodes): array
    {
        $segments = [];

        foreach ($nodes as $node) {
            $segments []= XMLElementParser::parse($node, new Segment(), self::$map);
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

        if ($segment->points) {
            foreach ($segment->points as $trkpt) {
                $node->appendChild(PointParser::toXML($trkpt, $doc));
            }
        }

        if ($segment->extensions) {
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
     * @param array<Segment> $segments
     * @param DOMDocument $doc
     * @return array<DOMNode>
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
