<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\GPXToolbox;
use GPXToolbox\Types\Extensions\ExtensionInterface;

class ExtensionParser
{
    /**
     * Extensions which have beed parsed.
     * @var array
     */
    public static $PARSED_EXTENSIONS = [];

    /**
     * Parses extension data.
     * @param \SimpleXMLElement $nodes
     * @return array
     */
    public static function parse($nodes): array
    {
        $extensions = [];

        foreach (GPXToolbox::$EXTENSIONS as $extension) {
            $children = $nodes->children($extension::EXTENSION_NAMESPACE);
            if (empty($children)) {
                continue;
            }

            $node = $children->{$extension::EXTENSION_NAME};
            if (empty($node)) {
                continue;
            }

            $extensions []= $extension::EXTENSION_PARSER::parse($node);

            if (!in_array($extension, self::$PARSED_EXTENSIONS)) {
                self::$PARSED_EXTENSIONS []= $extension;
            }
        }

        return $extensions;
    }

    /**
     * XML representation of extension data.
     * @param ExtensionInterface $extension
     * @param \DOMDocument $doc
     * @return \DOMNode
     */
    public static function toXML(ExtensionInterface $extension, \DOMDocument $doc): \DOMNode
    {
        return $extension::EXTENSION_PARSER::toXML($extension, $doc);
    }
}
