<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\GPXToolbox;
use GPXToolbox\Types\Bounds;
use DOMDocument;
use DOMNode;
use SimpleXMLElement;

class BoundsParser
{
    /**
     * Parses bounds data.
     * @param SimpleXMLElement $node
     * @return Bounds
     */
    public static function parse(SimpleXMLElement $node): Bounds
    {
        $bounds = new Bounds();

        if (isset($node['minlat'])) {
            $bounds->minlat = round((float) $node['minlat'], GPXToolbox::$COORDINATE_PRECISION);
        }
        if (isset($node['minlon'])) {
            $bounds->minlon = round((float) $node['minlon'], GPXToolbox::$COORDINATE_PRECISION);
        }
        if (isset($node['maxlat'])) {
            $bounds->maxlat = round((float) $node['maxlat'], GPXToolbox::$COORDINATE_PRECISION);
        }
        if (isset($node['maxlon'])) {
            $bounds->maxlon = round((float) $node['maxlon'], GPXToolbox::$COORDINATE_PRECISION);
        }

        return $bounds;
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
