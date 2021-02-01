<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Types\Bounds;

class BoundsParser
{
    /**
     * Parses bounds data.
     * @param \SimpleXMLElement $node
     * @return Bounds
     */
    public function parse(\SimpleXMLElement $node) : Bounds
    {
        $bounds = new Bounds();

        $bounds->minlat = isset($node['minlat']) ? (float) $node['minlat'] : null;
        $bounds->minlon = isset($node['minlon']) ? (float) $node['minlon'] : null;
        $bounds->maxlat = isset($node['maxlat']) ? (float) $node['maxlat'] : null;
        $bounds->maxlon = isset($node['maxlon']) ? (float) $node['maxlon'] : null;

        return $bounds;
    }

    /**
     * XML representation of bounds data.
     * @param Bounds $bounds
     * @param \DOMDocument $doc
     * @return \DOMNode
     */
    public static function toXML(Bounds $bounds, \DOMDocument $doc) : \DOMNode
    {
        $node = $doc->createElement('bounds');

        if (!empty($bounds->minlat)) {
            $node->setAttribute('minlat', $bounds->minlat);
        }

        if (!empty($bounds->minlon)) {
            $node->setAttribute('minlon', $bounds->minlon);
        }

        if (!empty($bounds->maxlat)) {
            $node->setAttribute('maxlat', $bounds->maxlat);
        }

        if (!empty($bounds->maxlon)) {
            $node->setAttribute('maxlon', $bounds->maxlon);
        }

        return $node;
    }
}
