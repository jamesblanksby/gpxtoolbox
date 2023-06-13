<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Parsers\Values\CoordinateParser;
use GPXToolbox\Types\Bounds;
use DOMDocument;
use DOMNode;
use SimpleXMLElement;

class BoundsParser
{
    /**
     * @var array<mixed>
     */
    private static $map = [
        'minlat' => [
            'name' => 'minlat',
            'type' => 'attribute',
            'parser' => CoordinateParser::class,
        ],
        'minlon' => [
            'name' => 'minlon',
            'type' => 'attribute',
            'parser' => CoordinateParser::class,
        ],
        'maxlat' => [
            'name' => 'maxlat',
            'type' => 'attribute',
            'parser' => CoordinateParser::class,
        ],
        'maxlon' => [
            'name' => 'maxlon',
            'type' => 'attribute',
            'parser' => CoordinateParser::class,
        ],
    ];

    /**
     * Parses bounds data.
     * @param SimpleXMLElement $node
     * @return Bounds
     */
    public static function parse(SimpleXMLElement $node): Bounds
    {
        return XMLElementParser::parse($node, new Bounds(), self::$map);
    }

    /**
     * XML representation of bounds data.
     * @param Bounds $bounds
     * @param DOMDocument $doc
     * @return DOMNode
     */
    public static function toXML(Bounds $bounds, DOMDocument $doc): DOMNode
    {
        $node = $doc->createElement('bounds');

        if ($bounds->minlat) {
            $node->setAttribute('minlat', (string) $bounds->minlat);
        }

        if ($bounds->minlon) {
            $node->setAttribute('minlon', (string) $bounds->minlon);
        }

        if ($bounds->maxlat) {
            $node->setAttribute('maxlat', (string) $bounds->maxlat);
        }

        if ($bounds->maxlon) {
            $node->setAttribute('maxlon', (string) $bounds->maxlon);
        }

        return $node;
    }
}
