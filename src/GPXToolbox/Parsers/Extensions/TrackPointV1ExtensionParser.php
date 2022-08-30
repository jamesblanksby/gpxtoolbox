<?php

namespace GPXToolbox\Parsers\Extensions;

use GPXToolbox\Types\Extensions\TrackPointV1Extension;
use GPXToolbox\Types\Extensions\ExtensionInterface;

class TrackPointV1ExtensionParser implements ExtensionParserInterface
{
    /**
     * Parses track point extension data.
     * @param \SimpleXMLElement $node
     * @return ExtensionInterface
     */
    public static function parse(\SimpleXMLElement $node): ExtensionInterface
    {
        $extension = new TrackPointV1Extension();

        $extension->atemp   = isset($node->atemp) ? (float) $node->atemp : null;
        $extension->wtemp   = isset($node->wtemp) ? (float) $node->wtemp : null;
        $extension->depth   = isset($node->depth) ? (float) $node->depth : null;
        $extension->hr      = isset($node->hr) ? (int) $node->hr : null;
        $extension->cad     = isset($node->cad) ? (int) $node->cad : null;

        return $extension;
    }

    /**
     * XML representation of track point extension data.
     * @param ExtensionInterface $extension
     * @param \DOMDocument $doc
     * @return \DOMNode
     */
    public static function toXML(ExtensionInterface $extension, \DOMDocument $doc): \DOMNode
    {
        $node = $doc->createElement(self::createElementName(TrackPointV1Extension::EXTENSION_NAME));

        if (!empty($extension->atemp)) {
            $child = $doc->createElement(self::createElementName('atemp'), $extension->atemp);
            $node->appendChild($child);
        }

        if (!empty($extension->wtemp)) {
            $child = $doc->createElement(self::createElementName('wtemp'), $extension->wtemp);
            $node->appendChild($child);
        }

        if (!empty($extension->depth)) {
            $child = $doc->createElement(self::createElementName('depth'), $extension->depth);
            $node->appendChild($child);
        }

        if (!empty($extension->hr)) {
            $child = $doc->createElement(self::createElementName('hr'), $extension->hr);
            $node->appendChild($child);
        }

        if (!empty($extension->cad)) {
            $child = $doc->createElement(self::createElementName('cad'), $extension->cad);
            $node->appendChild($child);
        }

        return $node;
    }

    /**
     * Generate delimited element name.
     * @param string $name
     * @return string
     */
    private static function createElementName(string $name): string
    {
        return sprintf('%s:%s', TrackPointV1Extension::EXTENSION_PREFIX, $name);
    }
}
