<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Interfaces\ArraySerializableInterface;
use SimpleXMLElement;

class XMLElementParser
{
    /**
     * @param SimpleXMLElement $node
     * @param ArraySerializableInterface $object
     * @param array<mixed> $map
     * @return mixed
     */
    public static function parse(SimpleXMLElement $node, ArraySerializableInterface $object, array $map): mixed
    {
        foreach ($map as $key => $element) {
            if ($element['type'] === 'attribute') {
                if (!isset($node[$key])) {
                    continue;
                }
                $value = $node[$key];
            } elseif ($element['type'] === 'element') {
                if (!isset($node->{$key})) {
                    continue;
                }
                $value = $node->{$key};
            }

            $callback = [$element['parser'], 'parse',];
            if (is_callable($callback)) {
                $object->{$element['name']} = call_user_func($callback, $value);
            } elseif (in_array($element['parser'], ['string', 'integer', 'float', 'boolean',])) {
                settype($value, $element['parser']);
                $object->{$element['name']} = $value;
            }
        }

        return $object;
    }
}
