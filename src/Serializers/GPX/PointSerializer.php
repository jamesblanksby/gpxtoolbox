<?php

namespace GPXToolbox\Serializers\GPX;

use GPXToolbox\Abstracts\GPX\GPXTypeSerializer;
use GPXToolbox\Models\GPX\Point;
use GPXToolbox\Models\GPX\PointCollection;
use GPXToolbox\Serializers\GPXSerializer;
use SimpleXMLElement;

class PointSerializer extends GPXTypeSerializer
{
    /**
     * Mapping of point properties to their parsing configuration.
     *
     * @var array
     */
    protected static $map = [
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
            'callable' => [GPXSerializer::class, 'serializeElevation',],
        ],
        'time' => [
            'type' => 'node',
            'callable' => [GPXSerializer::class, 'serializeDateTime',],
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
            'callable' => [LinkSerializer::class, 'serialize',],
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
     * Serialize point from a SimpleXMLElement.
     *
     * @param SimpleXMLElement $nodes
     * @return PointCollection
     */
    public static function serialize(SimpleXMLElement $nodes): PointCollection
    {
        $points = new PointCollection();

        foreach ($nodes as $node) {
            $properties = parent::propertiesFromXML($node, self::$map);

            $points->add(new Point($node->getName(), $properties));
        }

        return $points;
    }
}
