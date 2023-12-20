<?php

namespace GPXToolbox\Abstracts;

use GPXToolbox\Interfaces\Arrayable;
use GPXToolbox\Interfaces\Fillable;
use GPXToolbox\Interfaces\Jsonable;
use GPXToolbox\Serializers\ObjectSerializer;
use GPXToolbox\Traits\HasArrayable;

abstract class Model implements Arrayable, Fillable, Jsonable
{
    use HasArrayable;

    /**
     * Model constructor.
     *
     * @param mixed $collection
     */
    public function __construct($collection = null)
    {
        $this->fill($collection);
    }

    /**
     * Fill the model with data.
     *
     * @param mixed $collection
     * @return $this
     */
    public function fill($collection = null)
    {
        if (is_null($collection)) {
            return $this;
        }

        $reflector = new \ReflectionClass($this);

        $items = $this->getArrayableItems($collection);

        foreach ($items as $key => $value) {
            if (!$reflector->hasProperty($key)) {
                continue;
            }

            $property = $reflector->getProperty($key);

            if ($property->isStatic()) {
                continue;
            }

            if ($property->hasType()) {
                $type = $property->getType();

                if (!$type instanceof \ReflectionNamedType) {
                    continue;
                }

                $class = $type->getName();
                if (!is_null($value) && class_exists($class) && (!is_object($value) || get_class($value) !== $class)) {
                    $value = new $class($value);
                }
            }

            $method = sprintf('set%s', ucfirst($key));

            if ($reflector->hasMethod($method)) {
                $this->{$method}($value);
            } else {
                $property->setAccessible(true);
                $property->setValue($this, $value);
            }
        }

        return $this;
    }

    /**
     * Convert the model to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        $array = [];

        $reflector = new \ReflectionClass($this);

        $properties = $reflector->getProperties();

        foreach ($properties as $property) {
            if ($property->isStatic()) {
                continue;
            }

            $key = $property->getName();
            $method = sprintf('get%s', ucfirst($key));

            if ($reflector->hasMethod($method)) {
                $value = $this->{$method}();
            } else {
                $property->setAccessible(true);
                $value = $property->getValue($this);
            }

            if (is_object($value)) {
                $value = ObjectSerializer::serialize($value);
            }

            $array[$key] = $value;
        }

        return $array;
    }

    /**
     * Convert the model to its JSON representation.
     *
     * @param int $options
     * @return string
     */
    public function toJson(int $options = 0): string
    {
        return json_encode($this->serializeJson(), $options);
    }

    /**
     * Serialize the model to JSON.
     *
     * @return mixed
     */
    public function serializeJson()
    {
        return $this->toArray();
    }
}
