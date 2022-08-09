<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Types\Bounds;
use GPXToolbox\GPXToolbox;

class BoundsParser
{
    /**
     * Parses bounds data.
     * @param \SimpleXMLElement $node
     * @return Bounds
     */
    public static function parse(\SimpleXMLElement $node): Bounds
    {
        $bounds = new Bounds();

        $bounds->minlat = isset($node['minlat']) ? round((float) $node['minlat'], GPXToolbox::$COORDINATE_PRECISION) : null;
        $bounds->minlon = isset($node['minlon']) ? round((float) $node['minlon'], GPXToolbox::$COORDINATE_PRECISION) : null;
        $bounds->maxlat = isset($node['maxlat']) ? round((float) $node['maxlat'], GPXToolbox::$COORDINATE_PRECISION) : null;
        $bounds->maxlon = isset($node['maxlon']) ? round((float) $node['maxlon'], GPXToolbox::$COORDINATE_PRECISION) : null;

        return $bounds;
    }

    /**
     * XML representation of bounds data.
     * @param Bounds $bounds
     * @param \DOMDocument $doc
     * @return \DOMNode
     */
    public static function toXML(Bounds $bounds, \DOMDocument $doc): \DOMNode
    {
        $node = $doc->createElement('bounds');

        if (!empty($bounds->minlat)) {
            $node->setAttribute('minlat', (string) $bounds->minlat);
        }

        if (!empty($bounds->minlon)) {
            $node->setAttribute('minlon', (string) $bounds->minlon);
        }

        if (!empty($bounds->maxlat)) {
            $node->setAttribute('maxlat', (string) $bounds->maxlat);
        }

        if (!empty($bounds->maxlon)) {
            $node->setAttribute('maxlon', (string) $bounds->maxlon);
        }

        return $node;
    }
}
