<?php

namespace GPXToolbox\Abstracts\GPX;

use SimpleXMLElement;

abstract class GPXTypeSerializer
{
    /**
     * Serialize data from a SimpleXMLElement.
     *
     * @param SimpleXMLElement $node
     * @return GPXType|GPXTypeCollection
     */
    abstract public static function serialize(SimpleXMLElement $node);

    /**
     * Extracts an associative array of properties from a SimpleXMLElement.
     *
     * @param SimpleXMLElement $node
     * @param array $map
     * @return array
     */
    protected static function propertiesFromXML(SimpleXMLElement $node, array $map): array
    {
        $nodes = $node->children();
        $attributes = $node->attributes();

        $properties = [];

        foreach ($map as $key => $schema) {
            switch ($schema['type']) {
                case 'node':
                    if (isset($nodes->{$key})) {
                        $value = $nodes->{$key};
                    }
                    break;
                case 'attribute':
                    if (isset($attributes[$key])) {
                        $value = $attributes[$key];
                    }
                    break;
            }

            if (!isset($value) || !$value instanceof SimpleXMLElement) {
                continue;
            }

            if (isset($schema['callable'])) {
                $value = call_user_func($schema['callable'], $value);
            } elseif (isset($schema['cast'])) {
                settype($value, $schema['cast']);
            } else {
                $value = strval($value);
            }

            $properties[$key] = $value;
        }

        return $properties;
    }
}
