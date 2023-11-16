<?php

namespace GPXToolbox\Abstracts\GPX;

use GPXToolbox\Abstracts\Collection;
use SimpleXMLElement;

abstract class GPXTypeParser
{
    /**
     * Abstract method for parsing GPX data from a SimpleXMLElement.
     *
     * @param SimpleXMLElement $node
     * @return GPXType|Collection
     */
    abstract public static function parse(SimpleXMLElement $node);

    /**
     * Extracts an associative array of properties from a SimpleXMLElement.
     *
     * @param SimpleXMLElement $node
     * @param array $parseMap
     * @return array
     */
    protected static function propertiesFromXML(SimpleXMLElement $node, array $parseMap): array
    {
        $nodes = $node->children();
        $attributes = $node->attributes();

        $properties = [];

        foreach ($parseMap as $key => $schema) {
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
