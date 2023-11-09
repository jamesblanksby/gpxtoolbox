<?php

namespace GPXToolbox\Parsers\GPX;

use GPXToolbox\Abstracts\GPX\GPXTypeParser;
use GPXToolbox\Models\GPX\Bounds;
use SimpleXMLElement;

class BoundsParser extends GPXTypeParser
{
    /**
     * Mapping of bounds properties to their parsing configuration.
     *
     * @var array
     */
    protected static $parseMap = [
        'minlat' => [
            'type' => 'attribute',
            'cast' => 'float',
        ],
        'minlon' => [
            'type' => 'attribute',
            'cast' => 'float',
        ],
        'maxlat' => [
            'type' => 'attribute',
            'cast' => 'float',
        ],
        'maxlon' => [
            'type' => 'attribute',
            'cast' => 'float',
        ],
    ];

    /**
     * Parse bounds from a SimpleXMLElement.
     *
     * @param SimpleXMLElement $node
     * @return Bounds
     */
    public static function parse(SimpleXMLElement $node): Bounds
    {
        $properties = parent::propertiesFromXML($node, self::$parseMap);

        return new Bounds($properties);
    }
}
