<?php

namespace GPXToolbox\Parsers\Extensions;

use GPXToolbox\Types\Extensions\ExtensionInterface;
use GPXToolbox\Types\Extensions\StyleLineExtension;
use DOMDocument;
use DOMNode;
use SimpleXMLElement;

class StyleLineExtensionParser implements ExtensionParserInterface
{
    /**
     * @inheritDoc
     */
    public static function parse(SimpleXMLElement $node): ExtensionInterface
    {
        $extension = new StyleLineExtension();

        if (isset($node->color)) {
            $extension->color = (string) $node->color;
        }
        if (isset($node->opacity)) {
            $extension->opacity = (float) $node->opacity;
        }
        if (isset($node->width)) {
            $extension->width = (float) $node->width;
        }
        if (isset($node->pattern)) {
            $extension->pattern = (string) $node->pattern;
        }
        if (isset($node->linecap)) {
            $extension->linecap = (string) $node->linecap;
        }
        if (isset($node->dasharray)) {
            $extension->dasharray = self::parseDasharray($node->dasharray);
        }

        return $extension;
    }

    /**
     * @inheritDoc
     */
    public static function toXML(ExtensionInterface $extension, DOMDocument $doc): DOMNode
    {
        $node = $doc->createElement(StyleLineExtension::$EXTENSION_NAME);

        $node->setAttribute('xmlns', 'http://www.topografix.com/GPX/gpx_style/0/2');

        if (!empty($extension->color)) {
            $child = $doc->createElement('color', $extension->color);
            $node->appendChild($child);
        }

        if (!empty($extension->opacity)) {
            $child = $doc->createElement('opacity', $extension->opacity);
            $node->appendChild($child);
        }

        if (!empty($extension->width)) {
            $child = $doc->createElement('width', $extension->width);
            $node->appendChild($child);
        }

        if (!empty($extension->pattern)) {
            $child = $doc->createElement('pattern', $extension->pattern);
            $node->appendChild($child);
        }

        if (!empty($extension->linecap)) {
            $child = $doc->createElement('linecap', $extension->linecap);
            $node->appendChild($child);
        }

        if (!empty($extension->dasharray)) {
            $children = self::toXMLDasharrayArray($extension->dasharray, $doc);
            foreach ($children as $child) {
                $node->appendChild($child);
            }
        }

        return $node;
    }

    /**
     * Parses dasharray element data.
     * @param SimpleXMLElement $node
     * @return string[]
     */
    protected static function parseDasharray(SimpleXMLElement $node): array
    {
        $dasharray = [];

        foreach ($node->dash as $node) {
            $attributes = $node->attributes();
            $dasharray []= (string) $attributes['mark'];
            $dasharray []= (string) $attributes['space'];
        }

        return $dasharray;
    }

    /**
     * XML representation of dasharray element data.
     * @param string[] $dasharray
     * @param DOMDocument $doc
     * @return DOMNode[]
     */
    protected static function toXMLDasharrayArray(array $dasharray, DOMDocument $doc): array
    {
        $result = [];

        foreach ($dasharray as $dash) {
            $node = $doc->createElement('dash');

            $child = $doc->createElement('mark', $dash[0]);
            $node->appendChild($child);

            $child = $doc->createElement('space', $dash[1]);
            $node->appendChild($child);

            $result []= $node;
        }

        return $result;
    }
}
