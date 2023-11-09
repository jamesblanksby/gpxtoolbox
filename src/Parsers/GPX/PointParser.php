<?php

namespace GPXToolbox\Parsers\GPX;

use GPXToolbox\Abstracts\GPX\GPXTypeParser;
use GPXToolbox\Models\GPX\Point;
use GPXToolbox\Models\GPX\PointCollection;
use GPXToolbox\Parsers\GPXParser;
use SimpleXMLElement;

class PointParser extends GPXTypeParser
{
    /**
     * Mapping of point properties to their parsing configuration.
     *
     * @var array
     */
    protected static $parseMap = [
        'lat' => [
            'type' => 'attribute',
            'cast' => 'float',
        ],
        'lon' => [
            'type' => 'attribute',
            'cast' => 'float',
        ],
        'ele' => [
            'type' => 'node',
            'cast' => 'float',
        ],
        'time' => [
            'type' => 'node',
            'parser' => [GPXParser::class, 'parseDateTime',],
        ],
        'magvar' => [
            'type' => 'node',
            'cast' => 'float',
        ],
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
            'parser' => [LinkParser::class, 'parse',],
        ],
        'sym' => [
            'type' => 'node',
        ],
        'fix' => [
            'type' => 'node',
        ],
        'sat' => [
            'type' => 'node',
            'cast' => 'int',
        ],
        'hdop' => [
            'type' => 'node',
            'cast' => 'float',
        ],
        'vdop' => [
            'type' => 'node',
            'cast' => 'float',
        ],
        'pdop' => [
            'type' => 'node',
            'cast' => 'float',
        ],
        'dgpsid' => [
            'type' => 'node',
            'cast' => 'int',
        ],
    ];

    /**
     * Parse point from a SimpleXMLElement.
     *
     * @param SimpleXMLElement $nodes
     * @return PointCollection
     */
    public static function parse(SimpleXMLElement $nodes): PointCollection
    {
        $points = new PointCollection();

        foreach ($nodes as $node) {
            $properties = parent::propertiesFromXML($node, self::$parseMap);

            $points->add(new Point($node->getName(), $properties));
        }

        return $points;
    }
}
