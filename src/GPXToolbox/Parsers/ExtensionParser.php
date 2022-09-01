<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\GPXToolbox;
use GPXToolbox\Types\Extensions\ExtensionAbstract;

class ExtensionParser
{
    /**
     * Extensions which have beed parsed.
     * @var ExtensionAbstract[]
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
            $children = $nodes->children($extension::$EXTENSION_NAMESPACE);
            if (empty($children)) {
                continue;
            }

            $node = $children->{$extension::$EXTENSION_NAME};
            if (empty($node)) {
                continue;
            }

            $parser = $extension::$EXTENSION_PARSER;

            $extensions []= $parser::parse($node);

            if (!in_array($extension, self::$PARSED_EXTENSIONS)) {
                self::$PARSED_EXTENSIONS []= $extension;
            }
        }

        return $extensions;
    }

    /**
     * XML representation of extension data.
     * @param ExtensionAbstract $extension
     * @param \DOMDocument $doc
     * @return \DOMNode
     */
    public static function toXML(ExtensionAbstract $extension, \DOMDocument $doc): \DOMNode
    {
        $parser = $extension::$EXTENSION_PARSER;

        return $parser::toXML($extension, $doc);
    }

    /**
     * XML representation of array extension data.
     * @param ExtensionAbstract[] $extensions
     * @param \DOMDocument $doc
     * @return \DOMNode[]
     */
    public static function toXMLArray(array $extensions, \DOMDocument $doc): array
    {
        $result = [];

        foreach ($extensions as $extension) {
            $result []= self::toXML($extension, $doc);
        }

        return $result;
    }
}
