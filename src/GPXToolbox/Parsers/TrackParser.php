<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Types\Track;
use DOMDocument;
use DOMNode;
use SimpleXMLElement;

class TrackParser
{
    /**
     * @var array<mixed>
     */
    private static $map = [
        'name' => [
            'name' => 'name',
            'type' => 'element',
            'parser' => 'string',
        ],
        'cmt' => [
            'name' => 'cmt',
            'type' => 'element',
            'parser' => 'string',
        ],
        'desc' => [
            'name' => 'desc',
            'type' => 'element',
            'parser' => 'string',
        ],
        'src' => [
            'name' => 'src',
            'type' => 'element',
            'parser' => 'string',
        ],
        'link' => [
            'name' => 'links',
            'type' => 'element',
            'parser' => LinkParser::class,
        ],
        'number' => [
            'name' => 'number',
            'type' => 'element',
            'parser' => 'integer',
        ],
        'type' => [
            'name' => 'type',
            'type' => 'element',
            'parser' => 'string',
        ],
        'extensions' => [
            'name' => 'extensions',
            'type' => 'element',
            'parser' => ExtensionParser::class,
        ],
        'trkseg' => [
            'name' => 'trkseg',
            'type' => 'element',
            'parser' => SegmentParser::class,
        ],
    ];

    /**
     * Parses track data.
     * @param SimpleXMLElement $nodes
     * @return array<int, Track>
     */
    public static function parse($nodes): array
    {
        $tracks = [];

        foreach ($nodes as $node) {
            $tracks []= XMLElementParser::parse($node, new Track(), self::$map);
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
