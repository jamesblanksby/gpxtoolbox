<?php

namespace GPXToolbox\Parsers\Extensions;

use GPXToolbox\Types\Extensions\ExtensionInterface;
use GPXToolbox\Types\Extensions\TrackPointV2Extension;
use DOMDocument;
use DOMNode;
use SimpleXMLElement;

class TrackPointV2ExtensionParser implements ExtensionParserInterface
{
    /**
     * @inheritDoc
     */
    public static function parse(SimpleXMLElement $node): ExtensionInterface
    {
        $extension = new TrackPointV2Extension();

        if (isset($node->atemp)) {
            $extension->atemp = (float) $node->atemp;
        }
        if (isset($node->wtemp)) {
            $extension->wtemp = (float) $node->wtemp;
        }
        if (isset($node->depth)) {
            $extension->depth = (float) $node->depth;
        }
        if (isset($node->hr)) {
            $extension->hr = (int) $node->hr;
        }
        if (isset($node->cad)) {
            $extension->cad = (int) $node->cad;
        }
        if (isset($node->speed)) {
            $extension->speed = (float) $node->speed;
        }
        if (isset($node->course)) {
            $extension->course = (float) $node->course;
        }
        if (isset($node->bearing)) {
            $extension->bearing = (float) $node->bearing;
        }

        return $extension;
    }

    /**
     * @inheritDoc
     */
    public static function toXML(ExtensionInterface $extension, DOMDocument $doc): DOMNode
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
