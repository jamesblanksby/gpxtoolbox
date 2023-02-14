<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Types\Copyright;
use DOMDocument;
use DOMNode;
use SimpleXMLElement;

class CopyrightParser
{
    /**
     * Parses copyright data.
     * @param SimpleXMLElement $node
     * @return Copyright
     */
    public static function parse(SimpleXMLElement $node): Copyright
    {
        $copyright = new Copyright();

        if (isset($node['author'])) {
            $copyright->author = (string) $node['author'];
        }
        if (isset($node->year)) {
            $copyright->year = (string) $node->year;
        }
        if (isset($node->license)) {
            $copyright->license = (string) $node->license;
        }

        return $copyright;
    }

    /**
     * XML representation of copyright data.
     * @param Copyright $copyright
     * @param DOMDocument $doc
     * @return DOMNode
     */
    public static function toXML(Copyright $copyright, DOMDocument $doc): DOMNode
    {
        $node = $doc->createElement('copyright');

        if ($copyright->author) {
            $node->setAttribute('author', $copyright->author);
        }

        if ($copyright->year) {
            $child = $doc->createElement('year', $copyright->year);
            $node->appendChild($child);
        }

        if ($copyright->license) {
            $child = $doc->createElement('license', $copyright->license);
            $node->appendChild($child);
        }

        return $node;
    }
}
