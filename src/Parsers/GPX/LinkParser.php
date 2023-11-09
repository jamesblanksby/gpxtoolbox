<?php

namespace GPXToolbox\Parsers\GPX;

use GPXToolbox\Abstracts\GPX\GPXTypeParser;
use GPXToolbox\Models\GPX\Link;
use GPXToolbox\Models\GPX\LinkCollection;
use SimpleXMLElement;

class LinkParser extends GPXTypeParser
{
    /**
     * Mapping of link properties to their parsing configuration.
     *
     * @var array
     */
    protected static $parseMap = [
        'href' => [
            'type' => 'attribute',
        ],
        'text' => [
            'type' => 'node',
        ],
        'type' => [
            'type' => 'node',
        ],
    ];

    /**
     * Parse link from a SimpleXMLElement.
     *
     * @param SimpleXMLElement $nodes
     * @return LinkCollection
     */
    public static function parse(SimpleXMLElement $nodes): LinkCollection
    {
        $links = new LinkCollection();

        foreach ($nodes as $node) {
            $properties = parent::propertiesFromXML($node, self::$parseMap);

            $links->add(new Link($properties));
        }

        return $links;
    }
}
