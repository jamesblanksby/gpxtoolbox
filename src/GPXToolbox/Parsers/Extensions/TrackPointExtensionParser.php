<?php

namespace GPXToolbox\Parsers\Extensions;

use GPXToolbox\Types\Extensions\TrackPointExtension;
use GPXToolbox\Types\Extensions\ExtensionInterface;

class TrackPointExtensionParser implements ExtensionParserInterface
{
    /**
     * Parses track point extension data.
     * @param \SimpleXMLElement $node
     * @return ExtensionInterface
     */
    public static function parse(\SimpleXMLElement $node): ExtensionInterface
    {
        $extension = new TrackPointExtension();

        $extension->atemp   = isset($node->atemp) ? (float) $node->atemp : null;
        $extension->wtemp   = isset($node->wtemp) ? (float) $node->wtemp : null;
        $extension->depth   = isset($node->depth) ? (float) $node->depth : null;
        $extension->hr      = isset($node->hr) ? (int) $node->hr : null;
        $extension->cad     = isset($node->cad) ? (int) $node->cad : null;
        $extension->speed   = isset($node->speed) ? (float) $node->speed : null;
        $extension->course  = isset($node->course) ? (float) $node->course : null;
        $extension->bearing = isset($node->bearing) ? (float) $node->bearing : null;

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
        $node = $doc->createElement(self::createElementName(TrackPointExtension::EXTENSION_NAME));

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

        if (!empty($extension->speed)) {
            $child = $doc->createElement(self::createElementName('speed'), $extension->speed);
            $node->appendChild($child);
        }

        if (!empty($extension->course)) {
            $child = $doc->createElement(self::createElementName('course'), $extension->course);
            $node->appendChild($child);
        }

        if (!empty($extension->bearing)) {
            $child = $doc->createElement(self::createElementName('bearing'), $extension->bearing);
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
        return sprintf('gpxtx:%s', $name);
    }
}
