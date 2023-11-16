<?php

namespace GPXToolbox\Parsers\GPX;

use GPXToolbox\Abstracts\GPX\GPXTypeParser;
use GPXToolbox\Models\GPX\Author;
use SimpleXMLElement;

class AuthorParser extends GPXTypeParser
{
    /**
     * Mapping of author properties to their parsing configuration.
     *
     * @var array
     */
    protected static $parseMap = [
        'name' => [
            'type' => 'node',
        ],
        'email' => [
            'type' => 'node',
        ],
        'link' => [
            'type' => 'node',
            'callable' => [LinkParser::class, 'parse',],
        ],
    ];

    /**
     * Parse author from a SimpleXMLElement.
     *
     * @param SimpleXMLElement $node
     * @return Author
     */
    public static function parse(SimpleXMLElement $node): Author
    {
        $properties = parent::propertiesFromXML($node, self::$parseMap);

        return new Author($properties);
    }
}
