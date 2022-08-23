<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Types\Metadata;
use GPXToolbox\Helpers\DateTimeHelper;

class MetadataParser
{
    /**
     * Parses file metadata.
     * @param \SimpleXMLElement $node
     * @return Metadata
     */
    public static function parse(\SimpleXMLElement $node): Metadata
    {
        $metadata = new Metadata();

        $metadata->name       = isset($node->name) ? (string) $node->name : null;
        $metadata->desc       = isset($node->desc) ? (string) $node->desc : null;
        $metadata->author     = isset($node->author) ? PersonParser::parse($node->author) : null;
        $metadata->copyright  = isset($node->copyright) ? CopyrightParser::parse($node->copyright) : null;
        $metadata->links      = isset($node->link) ? LinkParser::parse($node->link) : null;
        $metadata->time       = isset($node->time) ? DateTimeParser::parse($node->time) : null;
        $metadata->keywords   = isset($node->keywords) ? (string) $node->keywords : null;
        $metadata->bounds     = isset($node->bounds) ? BoundsParser::parse($node->bounds) : null;
        $metadata->extensions = isset($node->extensions) ? ExtensionParser::parse($node->extensions) : null;

        return $metadata;
    }

    /**
     * XML representation of metadata.
     * @param Metadata $metadata
     * @param \DOMDocument $doc
     * @return \DOMNode
     */
    public static function toXML(Metadata $metadata, \DOMDocument $doc): \DOMNode
    {
        $node = $doc->createElement('metadata');

        if (!empty($metadata->name)) {
            $child = $doc->createElement('name', $metadata->name);
            $node->appendChild($child);
        }

        if (!empty($metadata->desc)) {
            $child = $doc->createElement('desc', $metadata->desc);
            $node->appendChild($child);
        }

        if (!empty($metadata->author)) {
            $child = PersonParser::toXML($metadata->author, $doc);
            $node->appendChild($child);
        }

        if (!empty($metadata->copyright)) {
            $child = CopyrightParser::toXML($metadata->copyright, $doc);
            $node->appendChild($child);
        }

        if (!empty($metadata->links)) {
            $children = LinkParser::toXMLArray($metadata->links, $doc);
            foreach ($children as $child) {
                $node->appendChild($child);
            }
        }

        if (!empty($metadata->time)) {
            $child = $doc->createElement('time', DateTimeHelper::format($metadata->time));
            $node->appendChild($child);
        }

        if (!empty($metadata->keywords)) {
            $child = $doc->createElement('keywords', $metadata->keywords);
            $node->appendChild($child);
        }

        if (!empty($metadata->bounds)) {
            $child = BoundsParser::toXML($metadata->bounds, $doc);
            $node->appendChild($child);
        }

        return $node;
    }
}
