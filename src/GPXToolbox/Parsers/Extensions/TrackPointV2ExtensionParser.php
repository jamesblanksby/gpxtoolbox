<?php

namespace GPXToolbox\Parsers\Extensions;

use GPXToolbox\Types\Extensions\ExtensionInterface;
use GPXToolbox\Types\Extensions\TrackPointV2Extension;
use DOMDocument;
use DOMNode;
use SimpleXMLElement;
use TypeError;

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
     * @throws TypeError
     */
    public static function toXML(ExtensionInterface $extension, DOMDocument $doc): DOMNode
    {
        if (!$extension instanceof TrackPointV2Extension) {
            throw new TypeError(sprintf('Argument #1 ($extension) must be of type %s, %s given', TrackPointV2Extension::class, get_class($extension)));
        }

        $node = $doc->createElement(self::createElementName(TrackPointV2Extension::$EXTENSION_NAME));

        if ($extension->atemp) {
            $child = $doc->createElement(self::createElementName('atemp'), (string) $extension->atemp);
            $node->appendChild($child);
        }

        if ($extension->wtemp) {
            $child = $doc->createElement(self::createElementName('wtemp'), (string) $extension->wtemp);
            $node->appendChild($child);
        }

        if ($extension->depth) {
            $child = $doc->createElement(self::createElementName('depth'), (string) $extension->depth);
            $node->appendChild($child);
        }

        if ($extension->hr) {
            $child = $doc->createElement(self::createElementName('hr'), (string) $extension->hr);
            $node->appendChild($child);
        }

        if ($extension->cad) {
            $child = $doc->createElement(self::createElementName('cad'), (string) $extension->cad);
            $node->appendChild($child);
        }

        if ($extension->speed) {
            $child = $doc->createElement(self::createElementName('speed'), (string) $extension->speed);
            $node->appendChild($child);
        }

        if ($extension->course) {
            $child = $doc->createElement(self::createElementName('course'), (string) $extension->course);
            $node->appendChild($child);
        }

        if ($extension->bearing) {
            $child = $doc->createElement(self::createElementName('bearing'), (string) $extension->bearing);
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
