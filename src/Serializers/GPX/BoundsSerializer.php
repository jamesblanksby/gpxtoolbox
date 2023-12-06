<?php

namespace GPXToolbox\Serializers\GPX;

use GPXToolbox\Abstracts\GPX\GPXTypeSerializer;
use GPXToolbox\Models\GPX\Bounds;
use SimpleXMLElement;

final class BoundsSerializer extends GPXTypeSerializer
{
    /**
     * Mapping of bounds properties to their parsing configuration.
     *
     * @var array
     */
    protected static $map = [
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
     * Serialize bounds from a SimpleXMLElement.
     *
     * @param SimpleXMLElement $node
     * @return Bounds
     */
    public static function serialize(SimpleXMLElement $node): Bounds
    {
        $properties = parent::propertiesFromXML($node, self::$map);

        return new Bounds($properties);
    }
}
