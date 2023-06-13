<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Types\Copyright;
use DOMDocument;
use DOMNode;
use SimpleXMLElement;

class CopyrightParser
{
    /**
     * @var array<mixed>
     */
    private static $map = [
        'author' => [
            'name' => 'author',
            'type' => 'attribute',
            'parser' => 'string',
        ],
        'year' => [
            'name' => 'year',
            'type' => 'element',
            'parser' => 'string',
        ],
        'license' => [
            'name' => 'license',
            'type' => 'element',
            'parser' => 'string',
        ],
    ];

    /**
     * Parses copyright data.
     * @param SimpleXMLElement $node
     * @return Copyright
     */
    public static function parse(SimpleXMLElement $node): Copyright
    {
        return XMLElementParser::parse($node, new Copyright(), self::$map);
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
