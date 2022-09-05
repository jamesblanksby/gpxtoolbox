<?php

namespace GPXToolbox\Parsers\Extensions;

use GPXToolbox\Types\Extensions\ExtensionAbstract;

interface ExtensionParserInterface
{
    /**
     * Parses extension data.
     * @param \SimpleXMLElement $node
     * @return ExtensionAbstract
     */
    public static function parse(\SimpleXMLElement $node): ExtensionAbstract;

    /**
     * XML representation of extension data.
     * @param ExtensionAbstract $extension
     * @param \DOMDocument $doc
     * @return \DOMNode
     */
    public static function toXML(ExtensionAbstract $extension, \DOMDocument $doc): \DOMNode;
}
