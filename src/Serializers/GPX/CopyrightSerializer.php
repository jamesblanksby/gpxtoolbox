<?php

namespace GPXToolbox\Serializers\GPX;

use GPXToolbox\Abstracts\GPX\GPXTypeSerializer;
use GPXToolbox\Models\GPX\Copyright;
use SimpleXMLElement;

final class CopyrightSerializer extends GPXTypeSerializer
{
    /**
     * Mapping of copyright properties to their parsing configuration.
     *
     * @var array
     */
    protected static $map = [
        'author' => [
            'type' => 'attribute',
        ],
        'year' => [
            'type' => 'node',
        ],
        'license' => [
            'type' => 'node',
        ],
    ];

    /**
     * Serialize copyright from a SimpleXMLElement.
     *
     * @param SimpleXMLElement $node
     * @return Copyright
     */
    public static function serialize(SimpleXMLElement $node): Copyright
    {
        $properties = parent::propertiesFromXML($node, self::$map);

        return new Copyright($properties);
    }
}
