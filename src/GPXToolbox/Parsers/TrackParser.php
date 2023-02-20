<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Types\Track;
use DOMDocument;
use DOMNode;
use SimpleXMLElement;

class TrackParser
{
    /**
     * Parses track data.
     * @param SimpleXMLElement $nodes
     * @return Track[]
     */
    public static function parse($nodes): array
    {
        $tracks = [];

        foreach ($nodes as $node) {
            $trk = new Track();

            if (isset($node->name)) {
                $trk->name = (string) $node->name;
            }
            if (isset($node->cmt)) {
                $trk->cmt = (string) $node->cmt;
            }
            if (isset($node->desc)) {
                $trk->desc = (string) $node->desc;
            }
            if (isset($node->src)) {
                $trk->src = (string) $node->src;
            }
            if (isset($node->link)) {
                $trk->links = LinkParser::parse($node->link);
            }
            if (isset($node->number)) {
                $trk->number = (int) $node->number;
            }
            if (isset($node->type)) {
                $trk->type = (string) $node->type;
            }
            if (isset($node->extensions)) {
                $trk->extensions = ExtensionParser::parse($node->extensions);
            }
            if (isset($node->trkseg)) {
                $trk->trkseg = SegmentParser::parse($node->trkseg);
            }

            $tracks []= $trk;
        }

        return $tracks;
    }

    /**
     * XML representation of track data.
     * @param Track $trk
     * @param DOMDocument $doc
     * @return DOMNode
     */
    public static function toXML(Track $trk, DOMDocument $doc): DOMNode
    {
        $node = $doc->createElement('trk');

        if ($trk->name) {
            $child = $doc->createElement('name', $trk->name);
            $node->appendChild($child);
        }

        if ($trk->cmt) {
            $child = $doc->createElement('cmt', $trk->cmt);
            $node->appendChild($child);
        }

        if ($trk->desc) {
            $child = $doc->createElement('desc', $trk->desc);
            $node->appendChild($child);
        }

        if ($trk->src) {
            $child = $doc->createElement('src', $trk->src);
            $node->appendChild($child);
        }

        if ($trk->links) {
            $children = LinkParser::toXMLArray($trk->links, $doc);
            foreach ($children as $child) {
                $node->appendChild($child);
            }
        }

        if ($trk->number) {
            $child = $doc->createElement('number', (string) $trk->number);
            $node->appendChild($child);
        }

        if ($trk->type) {
            $child = $doc->createElement('type', $trk->type);
            $node->appendChild($child);
        }

        if ($trk->extensions) {
            $child = $doc->createElement('extension');
            $node->appendChild($child);
            foreach ($trk->extensions as $extension) {
                $child->appendChild(ExtensionParser::toXML($extension, $doc));
            }
        }

        if ($trk->trkseg) {
            $children = SegmentParser::toXMLArray($trk->trkseg, $doc);
            foreach ($children as $child) {
                $node->appendChild($child);
            }
        }

        return $node;
    }
}
