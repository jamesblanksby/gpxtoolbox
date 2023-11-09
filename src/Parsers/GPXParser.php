<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Abstracts\GPX\GPXTypeParser;
use GPXToolbox\Models\GPX;
use GPXToolbox\Parsers\GPX\MetadataParser;
use GPXToolbox\Parsers\GPX\RouteParser;
use GPXToolbox\Parsers\GPX\TrackParser;
use GPXToolbox\Parsers\GPX\WaypointParser;
use DateTimeImmutable;
use SimpleXMLElement;

class GPXParser extends GPXTypeParser
{
    /**
     * Mapping of GPX file properties to their parsing configuration.
     *
     * @var array
     */
    protected static $parseMap = [
        'version' => [
            'type' => 'attribute',
        ],
        'creator' => [
            'type' => 'attribute',
        ],
        'metadata' => [
            'type' => 'node',
            'parser' => [MetadataParser::class, 'parse',],
        ],
        'wpt' => [
            'type' => 'node',
            'parser' => [WaypointParser::class, 'parse',],
        ],
        'rte' => [
            'type' => 'node',
            'parser' => [RouteParser::class, 'parse',],
        ],
        'trk' => [
            'type' => 'node',
            'parser' => [TrackParser::class, 'parse',],
        ],
    ];

    /**
     * Parse GPX data from a SimpleXMLElement.
     *
     * @param SimpleXMLElement $node
     * @return GPX
     */
    public static function parse(SimpleXMLElement $node): GPX
    {
        $properties = parent::propertiesFromXML($node, self::$parseMap);

        return new GPX($properties);
    }

    /**
     * Parse a string representation of a date and time.
     *
     * @param string $value
     * @return DateTimeImmutable
     */
    public static function parseDateTime(string $value): DateTimeImmutable
    {
        return new DateTimeImmutable($value);
    }
}
