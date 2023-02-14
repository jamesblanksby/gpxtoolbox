<?php

namespace GPXToolbox\Parsers\Extensions;

use GPXToolbox\Types\Extensions\ExtensionInterface;
use GPXToolbox\Types\Extensions\TrackPointV1Extension;
use DOMDocument;
use DOMNode;
use SimpleXMLElement;
use TypeError;

class TrackPointV1ExtensionParser implements ExtensionParserInterface
{
    /**
     * @inheritDoc
     */
    public static function parse(SimpleXMLElement $node): ExtensionInterface
    {
        $extension = new TrackPointV1Extension();

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

        return $extension;
    }

    /**
     * @inheritDoc
     * @throws TypeError
     */
    public static function toXML(ExtensionInterface $extension, DOMDocument $doc): DOMNode
    {
        if (!$extension instanceof TrackPointV1Extension) {
            throw new TypeError(sprintf('Argument #1 ($extension) must be of type %s, %s given', TrackPointV1Extension::class, get_class($extension)));
        }

        $node = $doc->createElement(self::createElementName(TrackPointV1Extension::$EXTENSION_NAME));

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

        return $node;
    }

    /**
     * Generate delimited element name.
     * @param string $name
     * @return string
     */
    private static function createElementName(string $name): string
    {
        return sprintf('%s:%s', TrackPointV1Extension::$EXTENSION_PREFIX, $name);
    }
}
