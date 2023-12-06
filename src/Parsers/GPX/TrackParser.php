<?php

namespace GPXToolbox\Parsers\GPX;

use GPXToolbox\Abstracts\GPX\GPXTypeParser;
use GPXToolbox\Models\GPX\Track;
use GPXToolbox\Models\GPX\TrackCollection;
use SimpleXMLElement;

final class TrackParser extends GPXTypeParser
{
    /**
     * Mapping of track properties to their parsing configuration.
     *
     * @var array
     */
    protected static $parseMap = [
        'name' => [
            'type' => 'node',
        ],
        'cmt' => [
            'type' => 'node',
        ],
        'desc' => [
            'type' => 'node',
        ],
        'src' => [
            'type' => 'node',
        ],
        'link' => [
            'type' => 'node',
            'callable' => [LinkParser::class, 'parse',],
        ],
        'number' => [
            'type' => 'node',
            'cast' => 'int',
        ],
        'type' => [
            'type' => 'node',
        ],
        'trkseg' => [
            'type' => 'node',
            'callable' => [SegmentParser::class, 'parse',],
        ],
    ];

    /**
     * Parse track from a SimpleXMLElement.
     *
     * @param SimpleXMLElement $nodes
     * @return TrackCollection
     */
    public static function parse(SimpleXMLElement $nodes): TrackCollection
    {
        $tracks = new TrackCollection();

        foreach ($nodes as $node) {
            $properties = parent::propertiesFromXML($node, self::$parseMap);

            $tracks->add(new Track($properties));
        }

        return $tracks;
    }
}
