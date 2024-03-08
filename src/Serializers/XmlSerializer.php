<?php

namespace GPXToolbox\Serializers;

class XmlSerializer
{
    /**
     * Serialize data to a DOMNode.
     *
     * @param \DOMDocument $doc
     * @param string $root
     * @param array $data
     * @return \DOMNode
     */
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

    /**
     * Set attributes on a DOMElement.
     *
     * @param \DOMElement $element
     * @param array $attributes
     */
    protected static function setAttributes(\DOMElement $element, array $attributes): void
    {
        foreach ($attributes as $key => $value) {
            $element->setAttribute($key, $value);
        }
    }

    /**
     * Append value to a DOMElement.
     *
     * @param \DOMDocument $doc
     * @param \DOMElement $parent
     * @param string $key
     * @param mixed $value
     */
    protected static function appendValue(\DOMDocument $doc, \DOMElement $parent, string $key, $value): void
    {
        if (is_array($value)) {
            self::appendArrayValues($doc, $parent, $key, $value);
        } else {
            $node = $doc->createElement($key, $value);
            $parent->appendChild($node);
        }
    }

    /**
     * Append array values to a DOMElement.
     *
     * @param \DOMDocument $doc
     * @param \DOMElement $parent
     * @param string $key
     * @param array $values
     */
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

    /**
     * Deserialize a DOMNode.
     *
     * @param \DOMNode $node
     * @return mixed
     */
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

    /**
     * Get attributes from a DOMNode.
     *
     * @param \DOMNode $node
     * @return array
     */
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

    /**
     * Append child value to data array.
     *
     * @param array $data
     * @param string $key
     * @param mixed $value
     * @return array
     */
    protected static function appendChildValue(array $data, string $key, $value): array
    {
        if (array_key_exists($key, $data)) {
            if (!is_array($data[$key]) || !array_is_list($data[$key])) {
                $data[$key] = [$data[$key],];
            }
            $data[$key][] = $value;
        } else {
            $data[$key] = $value;
        }

        return $data;
    }
}
