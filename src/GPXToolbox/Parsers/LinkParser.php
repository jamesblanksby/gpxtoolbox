<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Types\Link;
use DOMDocument;
use DOMNode;
use SimpleXMLElement;

class LinkParser
{
    /**
     * @var array<mixed>
     */
    private static $map = [
        'href' => [
            'name' => 'href',
            'type' => 'attribute',
            'parser' => 'string',
        ],
        'text' => [
            'name' => 'text',
            'type' => 'element',
            'parser' => 'string',
        ],
        'type' => [
            'name' => 'type',
            'type' => 'element',
            'parser' => 'string',
        ],
    ];

    /**
     * Parses link data.
     * @param array<SimpleXMLElement>|SimpleXMLElement $nodes
     * @return array<int, Link>
     */
    public static function parse($nodes): array
    {
        $links = [];

        foreach ($nodes as $node) {
            $links []= XMLElementParser::parse($node, new Link(), self::$map);
        }

        return $links;
    }

    /**
     * XML representation of link data.
     * @param Link $link
     * @param DOMDocument $doc
     * @return DOMNode
     */
    public static function toXML(Link $link, DOMDocument $doc): DOMNode
    {
        $node = $doc->createElement('link');

        if ($link->href) {
            $node->setAttribute('href', $link->href);
        }

        if ($link->text) {
            $child = $doc->createElement('text', $link->text);
            $node->appendChild($child);
        }

        if ($link->type) {
            $child = $doc->createElement('type', $link->type);
            $node->appendChild($child);
        }

        return $node;
    }

    /**
     * XML representation of array link data.
     * @param array<Link> $links
     * @param DOMDocument $doc
     * @return array<DOMNode>
     */
    public static function toXMLArray(array $links, DOMDocument $doc): array
    {
        $result = [];

        foreach ($links as $link) {
            $result []= self::toXML($link, $doc);
        }

        return $result;
    }
}
