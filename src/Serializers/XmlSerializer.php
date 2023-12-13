<?php

namespace GPXToolbox\Serializers;

final class XmlSerializer
{
    public static function serialize(\DOMDocument $doc, string $root, array $properties): \DOMNode
    {
        // @TODO use schema to determine whether element or attribute

        $node = $doc->createElement($root);

        foreach ($properties as $key => $value) {
            if (is_null($value)) {
                continue;
            }

            if (is_array($value)) {
                if (array_is_list($value)) {
                    foreach ($value as $item) {
                        $item = self::serialize($doc, $key, $item);
                        $node->appendChild($item);
                    }
                } else {
                    $value = self::serialize($doc, $key, $value);
                    $node->appendChild($value);
                }
            } else {
                $value = $doc->createElement($key, $value);
                $node->appendChild($value);
            }
        }

        return $node;
    }

    public static function deserialize(\DOMNode $node)
    {
        $properties = [];

        if ($node->hasAttributes()) {
            foreach ($node->attributes as $attribute) {
                $properties[$attribute->name] = $attribute->value;
            }
        }

        if ($node->hasChildNodes()) {
            foreach ($node->childNodes as $child) {
                if ($child->nodeType !== XML_ELEMENT_NODE) {
                    continue;
                }

                $key = $child->nodeName;
                $value = self::deserialize($child);

                if (array_key_exists($key, $properties)) {
                    if (!array_is_list($properties[$key])) {
                        $properties[$key] = [$properties[$key],];
                    }
                    $properties[$key][] = $value;
                } else {
                    $properties[$key] = $value;
                }
            }
        }

        if (!$properties) {
            $properties = trim($node->textContent);
        }

        return $properties;
    }
}
