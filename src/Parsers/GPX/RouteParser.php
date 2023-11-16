<?php

namespace GPXToolbox\Parsers\GPX;

use GPXToolbox\Abstracts\GPX\GPXTypeParser;
use GPXToolbox\Models\GPX\Route;
use GPXToolbox\Models\GPX\RouteCollection;
use SimpleXMLElement;

class RouteParser extends GPXTypeParser
{
    /**
     * Mapping of route properties to their parsing configuration.
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
        'rtept' => [
            'type' => 'node',
            'callable' => [PointParser::class, 'parse',],
        ],
    ];

    /**
     * Parse route from a SimpleXMLElement.
     *
     * @param SimpleXMLElement $nodes
     * @return RouteCollection
     */
    public static function parse(SimpleXMLElement $nodes): RouteCollection
    {
        $routes = new RouteCollection();

        foreach ($nodes as $node) {
            $properties = parent::propertiesFromXML($node, self::$parseMap);

            $routes->add(new Route($properties));
        }

        return $routes;
    }
}
