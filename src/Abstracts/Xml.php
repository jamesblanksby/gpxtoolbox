<?php

namespace GPXToolbox\Abstracts;

abstract class Xml extends Model
{
    protected ?array $attributes = null;

    public function fill($collection = null)
    {
        if ($collection === null) {
            return $this;
        }

        $collection = self::unwrapAttributes($collection);

        return parent::fill($collection);
    }

    public function toArray(): array
    {
        $array = parent::toArray();

        if (!is_null($this->attributes)) {
            $array = self::wrapAttributes($array, $this->attributes);
        }

        unset($array['attributes']);

        return $array;
    }

    public static function wrapAttributes(array $array, array $keys): array
    {
        $attributes = array_intersect_key($array, array_flip($keys));
        $array = array_merge(['@attributes' => $attributes,], array_diff_key($array, array_flip($keys)));

        return $array;
    }

    public static function unwrapAttributes(array $array): array
    {
        if (isset($array['@attributes'])) {
            $array = array_merge($array, $array['@attributes']);
            unset($array['@attributes']);
        }

        return $array;
    }
}
