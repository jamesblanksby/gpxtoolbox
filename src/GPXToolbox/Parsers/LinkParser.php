<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Types\Link;

class LinkParser
{
    /**
     * Parses link data.
     * @param \SimpleXMLElement[]|\SimpleXMLElement $nodes
     * @return Link[]
     */
    public static function parse($nodes) : array
    {
        $links = [];

        foreach ($nodes as $node) {
            $link = new Link();

            $link->href = isset($node['href']) ? (string) $node['href'] : null;
            $link->text = isset($node->text) ? (string) $node->text : null;
            $link->type = isset($node->type) ? (string) $node->type : null;

            $links []= $link;
        }

        return $links;
    }

    /**
     * XML representation of link data.
     * @param Link $link
     * @param \DOMDocument $doc
     * @return \DOMNode
     */
    public static function toXML(Link $link, \DOMDocument $doc) : \DOMNode
    {
        $node = $doc->createElement('link');

        if (!empty($link->href)) {
            $node->setAttribute('href', $link->href);
        }

        if (!empty($link->text)) {
            $child = $doc->createElement('text', $link->text);
            $node->appendChild($child);
        }

        if (!empty($link->type)) {
            $child = $doc->createElement('type', $link->type);
            $node->appendChild($child);
        }

        return $node;
    }

    /**
     * XML representation of array link data.
     * @param Link[] $links
     * @param \DOMDocument $doc
     * @return \DOMNode[]
     */
    public static function toXMLArray(array $links, \DOMDocument $doc) : array
    {
        $result = [];

        foreach ($links as $link) {
            $result []= self::toXML($link, $doc);
        }

        return $result;
    }
}
