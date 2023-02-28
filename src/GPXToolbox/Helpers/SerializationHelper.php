<?php

namespace GPXToolbox\Helpers;

use GPXToolbox\Interfaces\ArraySerializableInterface;

class SerializationHelper
{
    /**
     * Recursively remove empty array elements.
     * @param mixed[] $array
     * @return mixed[]
     */
    public static function filterNotNull(array $array): array
    {
        foreach ($array as &$item) {
            if (!is_array($item)) {
                continue;
            }

            $item = self::filterNotNull($item);
        }

        $array = array_filter($array, function ($item) {
            return !is_null($item) && (!is_array($item) || count($item));
        });

        return $array;
    }

    /**
     * Recursively convert ArraySerializable objects
     * to their array representation.
     * @param ArraySerializableInterface[]|ArraySerializableInterface|null $value
     * @return mixed[]|null
     */
    public static function toArray($value): ?array
    {
        if (is_array($value)) {
            $result = [];

            foreach ($value as $object) {
                $result []= $object->toArray();
            }

            return $result;
        }

        return !is_null($value) ? $value->toArray() : null;
    }
}
