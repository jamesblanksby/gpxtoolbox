<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Types\Link;
use DOMDocument;
use DOMNode;
use SimpleXMLElement;

class LinkParser
{
    /**
     * Parses link data.
     * @param SimpleXMLElement[]|SimpleXMLElement $nodes
     * @return Link[]
     */
    public static function parse($nodes): array
    {
        $links = [];

        foreach ($nodes as $node) {
            $link = new Link();

            if (isset($node['href'])) {
                $link->href = (string) $node['href'];
            }
            if (isset($node->text)) {
                $link->text = (string) $node->text;
            }
            if (isset($node->type)) {
                $link->type = (string) $node->type;
            }

            $links []= $link;
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
     * @param Link[] $links
     * @param DOMDocument $doc
     * @return DOMNode[]
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
