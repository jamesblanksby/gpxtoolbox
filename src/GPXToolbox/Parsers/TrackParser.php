<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Types\Track;

class TrackParser
{
    /**
     * Parses track data.
     * @param \SimpleXMLElement $nodes
     * @return array
     */
    public static function parse($nodes): array
    {
        $tracks = [];

        foreach ($nodes as $node) {
            $trk = new Track();

            $trk->name       = isset($node->name) ? (string) $node->name : null;
            $trk->cmt        = isset($node->cmt) ? (string) $node->cmt : null;
            $trk->desc       = isset($node->desc) ? (string) $node->desc : null;
            $trk->src        = isset($node->src) ? (string) $node->src : null;
            $trk->links      = isset($node->link) ? LinkParser::parse($node->link) : null;
            $trk->number     = isset($node->number) ? (int) $node->number : null;
            $trk->type       = isset($node->type) ? (string) $node->type : null;
            $trk->extensions = isset($node->extensions) ? ExtensionParser::parse($node->extensions) : null;
            $trk->trkseg     = isset($node->trkseg) ? SegmentParser::parse($node->trkseg) : null;

            $tracks []= $trk;
        }

        return $tracks;
    }

    /**
     * XML representation of track data.
     * @param Track $trk
     * @param \DOMDocument $doc
     * @return \DOMNode
     */
    public static function toXML(Track $trk, \DOMDocument $doc): \DOMNode
    {
        $node = $doc->createElement('trk');

        if (!empty($trk->name)) {
            $child = $doc->createElement('name', $trk->name);
            $node->appendChild($child);
        }

        if (!empty($trk->cmt)) {
            $child = $doc->createElement('cmt', $trk->cmt);
            $node->appendChild($child);
        }

        if (!empty($trk->desc)) {
            $child = $doc->createElement('desc', $trk->desc);
            $node->appendChild($child);
        }

        if (!empty($trk->src)) {
            $child = $doc->createElement('src', $trk->src);
            $node->appendChild($child);
        }

        if (!empty($trk->links)) {
            $children = LinkParser::toXMLArray($trk->links, $doc);
            foreach ($children as $child) {
                $node->appendChild($child);
            }
        }

        if (!empty($trk->number)) {
            $child = $doc->createElement('number', (string) $trk->number);
            $node->appendChild($child);
        }

        if (!empty($trk->type)) {
            $child = $doc->createElement('type', $trk->type);
            $node->appendChild($child);
        }

        if (!empty($trk->extensions)) {
            $child = $doc->createElement('extension');
            $node->appendChild($child);
            foreach ($trk->extensions as $extension) {
                $child->appendChild(ExtensionParser::toXML($extension, $doc));
            }
        }

        if (!empty($trk->trkseg)) {
            $children = SegmentParser::toXMLArray($trk->trkseg, $doc);
            foreach ($children as $child) {
                $node->appendChild($child);
            }
        }

        return $node;
    }
}
