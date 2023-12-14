<?php

namespace GPXToolbox\Serializers;

final class XmlSerializer
{
    public static function serialize(\DOMDocument $doc, string $root, array $data): \DOMNode
    {
        $node = $doc->createElement($root);

        foreach ($data as $key => $value) {
            if (is_null($value)) {
                continue;
            }

            if ($key === '@attributes') {
                self::setAttributes($node, $value);
            } else {
                self::appendValue($doc, $node, $key, $value);
            }
        }

        return $node;
    }

    protected static function setAttributes(\DOMElement $element, array $attributes): void
    {
        foreach ($attributes as $key => $value) {
            $element->setAttribute($key, $value);
        }
    }

    protected static function appendValue(\DOMDocument $doc, \DOMElement $parent, string $key, $value): void
    {
        if (is_array($value)) {
            self::appendArrayValues($doc, $parent, $key, $value);
        } else {
            $node = $doc->createElement($key, $value);
            $parent->appendChild($node);
        }
    }

    protected static function appendArrayValues(\DOMDocument $doc, \DOMElement $parent, string $key, array $values): void
    {
        if (array_is_list($values)) {
            foreach ($values as $value) {
                $node = self::serialize($doc, $key, $value);
                $parent->appendChild($node);
            }
        } else {
            $node = self::serialize($doc, $key, $values);
            $parent->appendChild($node);
        }
    }

    public static function deserialize(\DOMNode $node)
    {
        $data = self::getAttributes($node);

        if ($node->hasChildNodes()) {
            foreach ($node->childNodes as $child) {
                if ($child->nodeType !== XML_ELEMENT_NODE) {
                    continue;
                }

                $key = $child->nodeName;
                $value = self::deserialize($child);

                $data = self::appendChildValue($data, $key, $value);
            }
        }

        if (!$data) {
            $data = trim($node->textContent);
        }

        return $data;
    }

    protected static function getAttributes(\DOMNode $node): array
    {
        $attributes = [];

        if ($node->hasAttributes()) {
            foreach ($node->attributes as $attribute) {
                $attributes[$attribute->name] = $attribute->value;
            }
        }

        return $attributes ? ['@attributes' => $attributes,] : [];
    }

    protected static function appendChildValue(array $data, string $key, $value): array
    {
        if (array_key_exists($key, $data)) {
            if (!array_is_list($data[$key])) {
                $data[$key] = [$data[$key],];
            }
            $data[$key][] = $value;
        } else {
            $data[$key] = $value;
        }

        return $data;
    }
}
