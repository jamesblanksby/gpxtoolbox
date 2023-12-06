<?php

namespace GPXToolbox\Serializers\GPX;

use GPXToolbox\Abstracts\GPX\GPXTypeSerializer;
use GPXToolbox\Models\GPX\Metadata;
use GPXToolbox\Serializers\GPXSerializer;
use SimpleXMLElement;

final class MetadataSerializer extends GPXTypeSerializer
{
    /**
     * Mapping of metadata properties to their parsing configuration.
     *
     * @var array
     */
    protected static $map = [
        'name' => [
            'type' => 'node',
        ],
        'desc' => [
            'type' => 'node',
        ],
        'author' => [
            'type' => 'node',
            'callable' => [AuthorSerializer::class, 'serialize',],
        ],
        'copyright' => [
            'type' => 'node',
            'callable' => [CopyrightSerializer::class, 'serialize',],
        ],
        'link' => [
            'type' => 'node',
            'callable' => [LinkSerializer::class, 'serialize',],
        ],
        'time' => [
            'type' => 'node',
            'callable' => [GPXSerializer::class, 'serializeDateTime',],
        ],
        'keywords' => [
            'type' => 'node',
        ],
        'bounds' => [
            'type' => 'node',
            'callable' => [BoundsSerializer::class, 'serialize',],
        ],
    ];

    /**
     * Serialize metadata from a SimpleXMLElement.
     *
     * @param SimpleXMLElement $node
     * @return Metadata
     */
    public static function serialize(SimpleXMLElement $node): Metadata
    {
        $properties = parent::propertiesFromXML($node, self::$map);

        return new Metadata($properties);
    }
}
