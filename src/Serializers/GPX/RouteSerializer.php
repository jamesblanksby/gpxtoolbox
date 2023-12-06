<?php

namespace GPXToolbox\Serializers\GPX;

use GPXToolbox\Abstracts\GPX\GPXTypeSerializer;
use GPXToolbox\Models\GPX\Route;
use GPXToolbox\Models\GPX\RouteCollection;
use SimpleXMLElement;

final class RouteSerializer extends GPXTypeSerializer
{
    /**
     * Mapping of route properties to their parsing configuration.
     *
     * @var array
     */
    protected static $map = [
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
            'callable' => [LinkSerializer::class, 'serialize',],
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
            'callable' => [PointSerializer::class, 'serialize',],
        ],
    ];

    /**
     * Serialize route from a SimpleXMLElement.
     *
     * @param SimpleXMLElement $nodes
     * @return RouteCollection
     */
    public static function serialize(SimpleXMLElement $nodes): RouteCollection
    {
        $routes = new RouteCollection();

        foreach ($nodes as $node) {
            $properties = parent::propertiesFromXML($node, self::$map);

            $routes->add(new Route($properties));
        }

        return $routes;
    }
}
