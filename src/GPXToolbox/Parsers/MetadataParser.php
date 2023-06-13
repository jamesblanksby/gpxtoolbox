<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Helpers\DateTimeHelper;
use GPXToolbox\Parsers\Values\DateTimeParser;
use GPXToolbox\Types\Metadata;
use DOMDocument;
use DOMNode;
use SimpleXMLElement;

class MetadataParser
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
        'desc' => [
            'name' => 'desc',
            'type' => 'element',
            'parser' => 'string',
        ],
        'author' => [
            'name' => 'author',
            'type' => 'element',
            'parser' => PersonParser::class,
        ],
        'copyright' => [
            'name' => 'copyright',
            'type' => 'element',
            'parser' => CopyrightParser::class,
        ],
        'link' => [
            'name' => 'links',
            'type' => 'element',
            'parser' => LinkParser::class,
        ],
        'time' => [
            'name' => 'time',
            'type' => 'element',
            'parser' => DateTimeParser::class,
        ],
        'keywords' => [
            'name' => 'keywords',
            'type' => 'element',
            'parser' => 'string',
        ],
        'bounds' => [
            'name' => 'bounds',
            'type' => 'element',
            'parser' => BoundsParser::class,
        ],
        'extensions' => [
            'name' => 'extensions',
            'type' => 'element',
            'parser' => ExtensionParser::class,
        ],
    ];

    /**
     * Parses file metadata.
     * @param SimpleXMLElement $node
     * @return Metadata
     */
    public static function parse(SimpleXMLElement $node): Metadata
    {
        return XMLElementParser::parse($node, new Metadata(), self::$map);
    }

    /**
     * XML representation of metadata.
     * @param Metadata $metadata
     * @param DOMDocument $doc
     * @return DOMNode
     */
    public static function toXML(Metadata $metadata, DOMDocument $doc): DOMNode
    {
        $node = $doc->createElement('metadata');

        if ($metadata->name) {
            $child = $doc->createElement('name', $metadata->name);
            $node->appendChild($child);
        }

        if ($metadata->desc) {
            $child = $doc->createElement('desc', $metadata->desc);
            $node->appendChild($child);
        }

        if ($metadata->author) {
            $child = PersonParser::toXML($metadata->author, $doc);
            $node->appendChild($child);
        }

        if ($metadata->copyright) {
            $child = CopyrightParser::toXML($metadata->copyright, $doc);
            $node->appendChild($child);
        }

        if ($metadata->links) {
            $children = LinkParser::toXMLArray($metadata->links, $doc);
            foreach ($children as $child) {
                $node->appendChild($child);
            }
        }

        if ($metadata->time) {
            $time = DateTimeHelper::format($metadata->time);
            if (!is_null($time)) {
                $child = $doc->createElement('time', $time);
                $node->appendChild($child);
            }
        }

        if ($metadata->keywords) {
            $child = $doc->createElement('keywords', $metadata->keywords);
            $node->appendChild($child);
        }

        if ($metadata->bounds) {
            $child = BoundsParser::toXML($metadata->bounds, $doc);
            $node->appendChild($child);
        }

        if ($metadata->extensions) {
            $child = $doc->createElement('extension');
            $node->appendChild($child);
            foreach ($metadata->extensions as $extension) {
                $child->appendChild(ExtensionParser::toXML($extension, $doc));
            }
        }

        return $node;
    }
}
