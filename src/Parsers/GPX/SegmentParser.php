<?php

namespace GPXToolbox\Parsers\GPX;

use GPXToolbox\Abstracts\GPX\GPXTypeParser;
use GPXToolbox\Models\GPX\Segment;
use GPXToolbox\Models\GPX\SegmentCollection;
use SimpleXMLElement;

final class SegmentParser extends GPXTypeParser
{
    /**
     * Mapping of segment properties to their parsing configuration.
     *
     * @var array
     */
    protected static $parseMap = [
        'trkpt' => [
            'type' => 'node',
            'callable' => [PointParser::class, 'parse',],
        ],
    ];

    /**
     * Parse segment from a SimpleXMLElement.
     *
     * @param SimpleXMLElement $nodes
     * @return SegmentCollection
     */
    public static function parse(SimpleXMLElement $nodes): SegmentCollection
    {
        $segments = new SegmentCollection();

        foreach ($nodes as $node) {
            $properties = parent::propertiesFromXML($node, self::$parseMap);

            $segments->add(new Segment($properties));
        }

        return $segments;
    }
}
