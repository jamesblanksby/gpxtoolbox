<?php

namespace GPXToolbox\Parsers\Extensions;

use GPXToolbox\Types\Extensions\ExtensionInterface;
use DOMDocument;
use DOMNode;
use SimpleXMLElement;

interface ExtensionParserInterface
{
    /**
     * Parses extension data.
     * @param SimpleXMLElement $node
     * @return ExtensionInterface
     */
    public static function parse(SimpleXMLElement $node): ExtensionInterface;

    /**
     * XML representation of extension data.
     * @param ExtensionInterface $extension
     * @param DOMDocument $doc
     * @return DOMNode
     */
    public static function toXML(ExtensionInterface $extension, DOMDocument $doc): DOMNode;
}
