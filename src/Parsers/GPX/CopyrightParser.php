<?php

namespace GPXToolbox\Parsers\GPX;

use GPXToolbox\Abstracts\GPX\GPXTypeParser;
use GPXToolbox\Models\GPX\Copyright;
use SimpleXMLElement;

class CopyrightParser extends GPXTypeParser
{
    /**
     * Mapping of copyright properties to their parsing configuration.
     *
     * @var array
     */
    protected static $parseMap = [
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
     * Parse copyright from a SimpleXMLElement.
     *
     * @param SimpleXMLElement $node
     * @return Copyright
     */
    public static function parse(SimpleXMLElement $node): Copyright
    {
        $properties = parent::propertiesFromXML($node, self::$parseMap);

        return new Copyright($properties);
    }
}
