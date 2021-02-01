<?php

namespace GPXToolbox\Helpers;

class SerializationHelper
{
    /**
     * Recursively remove empty array elements.
     * @param array $array
     * @return array
     */
    public static function filterEmpty(array $array) : array
    {
        foreach ($array as &$item) {
            if (!is_array($item)) {
                continue;
            }

            $item = self::filterEmpty($item);
        }

        $array = array_filter($array, function ($item) {
            return !empty($item);
        });

        return $array;
    }

    /**
     * Recursively convert objects their array representation.
     * @param mixed $object
     * @return array|null
     */
    public static function toArray($object) : ?array
    {
        if (!is_array($object)) {
            return !is_null($object) ? $object->toArray() : null;
        }

        $result = [];
        
        foreach ($object as $item) {
            $result []= $item->toArray();
        }
        
        return $result;
    }
}
