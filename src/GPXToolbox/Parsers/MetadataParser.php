<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Helpers\DateTimeHelper;
use GPXToolbox\Types\Metadata;
use DOMDocument;
use DOMNode;
use SimpleXMLElement;

class MetadataParser
{
    /**
     * Parses file metadata.
     * @param SimpleXMLElement $node
     * @return Metadata
     */
    public static function parse(SimpleXMLElement $node): Metadata
    {
        $metadata = new Metadata();

        if (isset($node->name)) {
            $metadata->name = (string) $node->name;
        }
        if (isset($node->desc)) {
            $metadata->desc = (string) $node->desc;
        }
        if (isset($node->author)) {
            $metadata->author = PersonParser::parse($node->author);
        }
        if (isset($node->copyright)) {
            $metadata->copyright = CopyrightParser::parse($node->copyright);
        }
        if (isset($node->link)) {
            $metadata->links = LinkParser::parse($node->link);
        }
        if (isset($node->time)) {
            $metadata->time = DateTimeParser::parse($node->time);
        }
        if (isset($node->keywords)) {
            $metadata->keywords = (string) $node->keywords;
        }
        if (isset($node->bounds)) {
            $metadata->bounds = BoundsParser::parse($node->bounds);
        }
        if (isset($node->extensions)) {
            $metadata->extensions= ExtensionParser::parse($node->extensions);
        }

        return $metadata;
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

        if (!empty($metadata->extensions)) {
            $child = $doc->createElement('extension');
            $node->appendChild($child);
            foreach ($metadata->extensions as $extension) {
                $child->appendChild(ExtensionParser::toXML($extension, $doc));
            }
        }

        return $node;
    }
}
