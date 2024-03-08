<?php

namespace GPXToolbox\Abstracts;

abstract class Xml extends Model
{
    /**
     * @var array|null Attributes associated with the XML element.
     */
    protected ?array $attributes = null;

    /**
     * Fill the XML model with data.
     *
     * @param mixed $collection
     * @return $this
     */
    public function fill($collection = null)
    {
        if ($collection === null) {
            return $this;
        }

        $collection = self::unwrapAttributes($collection);

        return parent::fill($collection);
    }

    /**
     * Convert the XML model to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        $array = parent::toArray();

        unset($array['attributes']);

        return $array;
    }

    /**
     * Convert the XML model to an XML array.
     *
     * @return array
     */
    public function toXmlArray(): array
    {
        $array = $this->toArray();

        if (!is_null($this->attributes)) {
            $array = self::wrapAttributes($array, $this->attributes);
        }

        return $array;
    }

    /**
     * Wrap attributes into a sub-array.
     *
     * @param array $array
     * @param array $keys
     * @return array
     */
    public static function wrapAttributes(array $array, array $keys): array
    {
        $attributes = array_intersect_key($array, array_flip($keys));
        $array = array_merge(['@attributes' => $attributes,], array_diff_key($array, array_flip($keys)));

        return $array;
    }

    /**
     * Unwrap attributes from a sub-array.
     *
     * @param array $array
     * @return array
     */
    public static function unwrapAttributes(array $array): array
    {
        if (isset($array['@attributes'])) {
            $array = array_merge($array, $array['@attributes']);
            unset($array['@attributes']);
        }

        return $array;
    }
}
