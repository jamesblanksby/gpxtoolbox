<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Types\Copyright;

class CopyrightParser
{
    /**
     * Parses copyright data.
     * @param \SimpleXMLElement $node
     * @return Copyright
     */
    public function parse(\SimpleXMLElement $node) : Copyright
    {
        $copyright = new Copyright();

        $copyright->author  = isset($node['author']) ? (string) $node['author'] : null;
        $copyright->year    = isset($node->year) ? (string) $node->year : null;
        $copyright->license = isset($node->license) ? (string) $node->license : null;

        return $copyright;
    }

    /**
     * XML representation of copyright data.
     * @param Copyright $copyright
     * @param \DOMDocument $doc
     * @return \DOMNode
     */
    public static function toXML(Copyright $copyright, \DOMDocument $doc) : \DOMNode
    {
        $node = $doc->createElement('copyright');

        if (!empty($copyright->author)) {
            $node->setAttribute('author', $copyright->author);
        }

        if (!empty($copyright->year)) {
            $child = $document->createElement('year', $copyright->year);
            $node->appendChild($child);
        }

        if (!empty($copyright->license)) {
            $child = $document->createElement('license', $copyright->license);
            $node->appendChild($child);
        }

        return $node;
    }
}
