<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Abstracts\GPX\GPXTypeParser;
use GPXToolbox\Models\GPX;
use GPXToolbox\Parsers\GPX\MetadataParser;
use GPXToolbox\Parsers\GPX\RouteParser;
use GPXToolbox\Parsers\GPX\TrackParser;
use GPXToolbox\Parsers\GPX\WaypointParser;
use DateTimeImmutable;
use GPXToolbox\GPXToolbox;
use SimpleXMLElement;

final class GPXParser extends GPXTypeParser
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
            'callable' => [MetadataParser::class, 'parse',],
        ],
        'wpt' => [
            'type' => 'node',
            'callable' => [WaypointParser::class, 'parse',],
        ],
        'rte' => [
            'type' => 'node',
            'callable' => [RouteParser::class, 'parse',],
        ],
        'trk' => [
            'type' => 'node',
            'callable' => [TrackParser::class, 'parse',],
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
     * Parse a coordinate value from a string.
     *
     * @param string $value
     * @return float
     */
    public static function parseCoordinate(string $value): float
    {
        return round((float) $value, GPXToolbox::getConfiguration()->getCoordinatePrecision());
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

    /**
     * Parse an elevation value from a string.
     *
     * @param string $value
     * @return float
     */
    public static function parseElevation(string $value): float
    {
        return round((float) $value, GPXToolbox::getConfiguration()->getElevationPrecision());
    }
}
