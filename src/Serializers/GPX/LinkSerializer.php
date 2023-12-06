<?php

namespace GPXToolbox\Serializers\GPX;

use GPXToolbox\Abstracts\GPX\GPXTypeSerializer;
use GPXToolbox\Models\GPX\Link;
use GPXToolbox\Models\GPX\LinkCollection;
use SimpleXMLElement;

final class LinkSerializer extends GPXTypeSerializer
{
    /**
     * Mapping of link properties to their parsing configuration.
     *
     * @var array
     */
    protected static $map = [
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
     * Serialize link from a SimpleXMLElement.
     *
     * @param SimpleXMLElement $nodes
     * @return LinkCollection
     */
    public static function serialize(SimpleXMLElement $nodes): LinkCollection
    {
        $links = new LinkCollection();

        foreach ($nodes as $node) {
            $properties = parent::propertiesFromXML($node, self::$map);

            $links->add(new Link($properties));
        }

        return $links;
    }
}
