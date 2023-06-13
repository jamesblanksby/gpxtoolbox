<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Types\GPX;
use SimpleXMLElement;

class GPXParser
{
    /**
     * @var array<mixed>
     */
    private static $map = [
        'version' => [
            'name' => 'version',
            'type' => 'attribute',
            'parser' => 'string',
        ],
        'creator' => [
            'name' => 'creator',
            'type' => 'attribute',
            'parser' => 'string',
        ],
        'metadata' => [
            'name' => 'metadata',
            'type' => 'element',
            'parser' => MetadataParser::class,
        ],
        'wpt' => [
            'name' => 'wpt',
            'type' => 'element',
            'parser' => PointParser::class,
        ],
        'rte' => [
            'name' => 'rte',
            'type' => 'element',
            'parser' => RouteParser::class,
        ],
        'trk' => [
            'name' => 'trk',
            'type' => 'element',
            'parser' => TrackParser::class,
        ],
        'extensions' => [
            'name' => 'extensions',
            'type' => 'element',
            'parser' => ExtensionParser::class,
        ],
    ];

    /**
     * Parses GPX data.
     * @param SimpleXMLElement $node
     * @return GPX
     */
    public static function parse(SimpleXMLElement $node): GPX
    {
        return XMLElementParser::parse($node, new GPX(), self::$map);
    }
}
