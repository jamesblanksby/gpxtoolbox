<?php

namespace GPXToolbox\Parsers\Extensions;

use GPXToolbox\Types\Extensions\ExtensionAbstract;
use GPXToolbox\Types\Extensions\TrackPointV2Extension;
use DOMDocument;
use DOMNode;
use SimpleXMLElement;

class TrackPointV2ExtensionParser implements ExtensionParserInterface
{
    /**
     * @inheritDoc
     */
    public static function parse(SimpleXMLElement $node): ExtensionAbstract
    {
        $extension = new TrackPointV2Extension();

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
     * @inheritDoc
     */
    public static function toXML(ExtensionAbstract $extension, DOMDocument $doc): DOMNode
    {
        $node = $doc->createElement(self::createElementName(TrackPointV2Extension::$EXTENSION_NAME));

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
        return sprintf('%s:%s', TrackPointV2Extension::$EXTENSION_PREFIX, $name);
    }
}
