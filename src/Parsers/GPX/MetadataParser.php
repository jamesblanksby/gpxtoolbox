<?php

namespace GPXToolbox\Parsers\GPX;

use GPXToolbox\Abstracts\GPX\GPXTypeParser;
use GPXToolbox\Models\GPX\Metadata;
use GPXToolbox\Parsers\GPXParser;
use SimpleXMLElement;

class MetadataParser extends GPXTypeParser
{
    /**
     * Mapping of metadata properties to their parsing configuration.
     *
     * @var array
     */
    protected static $parseMap = [
        'name' => [
            'type' => 'node',
        ],
        'desc' => [
            'type' => 'node',
        ],
        'author' => [
            'type' => 'node',
            'callable' => [AuthorParser::class, 'parse',],
        ],
        'copyright' => [
            'type' => 'node',
            'callable' => [CopyrightParser::class, 'parse',],
        ],
        'link' => [
            'type' => 'node',
            'callable' => [LinkParser::class, 'parse',],
        ],
        'time' => [
            'type' => 'node',
            'callable' => [GPXParser::class, 'parseDateTime',],
        ],
        'keywords' => [
            'type' => 'node',
        ],
        'bounds' => [
            'type' => 'node',
            'callable' => [BoundsParser::class, 'parse',],
        ],
    ];

    /**
     * Parse metadata from a SimpleXMLElement.
     *
     * @param SimpleXMLElement $node
     * @return Metadata
     */
    public static function parse(SimpleXMLElement $node): Metadata
    {
        $properties = parent::propertiesFromXML($node, self::$parseMap);

        return new Metadata($properties);
    }
}
