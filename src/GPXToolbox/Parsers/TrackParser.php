<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Types\Track;
use DOMDocument;
use DOMNode;
use SimpleXMLElement;

class TrackParser
{
    /**
     * Track attribute definition.
     * @var string[][]
     */
    private static $attributeMap = [
        'name' => [
            'key' => 'name',
            'parser' => 'string',
        ],
        'cmt' => [
            'key' => 'cmt',
            'parser' => 'string',
        ],
        'desc' => [
            'key' => 'desc',
            'parser' => 'string',
        ],
        'src' => [
            'key' => 'src',
            'parser' => 'string',
        ],
        'link' => [
            'key' => 'links',
            'parser' => LinkParser::class,
        ],
        'number' => [
            'key' => 'number',
            'parser' => 'integer',
        ],
        'type' => [
            'key' => 'type',
            'parser' => 'string',
        ],
        'extensions' => [
            'key' => 'extensions',
            'parser' => ExtensionParser::class,
        ],
        'trkseg' => [
            'key' => 'trkseg',
            'parser' => SegmentParser::class,
        ],
    ];

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

            foreach (self::$attributeMap as $key => $attribute) {
                if (!isset($node->{$key})) {
                    continue;
                }

                if (!method_exists($attribute['parser'], 'parse')) {
                    $trk->{$attribute['key']} = $node->{$key};
                    settype($trk->{$attribute['key']}, $attribute['parser']);
                } else {
                    $trk->{$attribute['key']} = $attribute['parser']::parse($node->{$key});
                }
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
