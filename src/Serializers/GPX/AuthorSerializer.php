<?php

namespace GPXToolbox\Serializers\GPX;

use GPXToolbox\Abstracts\GPX\GPXTypeSerializer;
use GPXToolbox\Models\GPX\Author;
use SimpleXMLElement;

final class AuthorSerializer extends GPXTypeSerializer
{
    /**
     * Mapping of author properties to their parsing configuration.
     *
     * @var array
     */
    protected static $map = [
        'name' => [
            'type' => 'node',
        ],
        'email' => [
            'type' => 'node',
        ],
        'link' => [
            'type' => 'node',
            'callable' => [LinkSerializer::class, 'serialize',],
        ],
    ];

    /**
     * Serialize author from a SimpleXMLElement.
     *
     * @param SimpleXMLElement $node
     * @return Author
     */
    public static function serialize(SimpleXMLElement $node): Author
    {
        $properties = parent::propertiesFromXML($node, self::$map);

        return new Author($properties);
    }
}
