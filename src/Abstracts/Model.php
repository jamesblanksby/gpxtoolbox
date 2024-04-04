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
            if ($this->shouldSkipProperty($reflector, $key)) {
                continue;
            }

            $this->setPropertyValue($reflector, $key, $value);
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
            $value = $this->getPropertyValue($reflector, $key);

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

    /**
     * @param \ReflectionClass $reflector
     * @param string $key
     * @return boolean
     */
    private function shouldSkipProperty(\ReflectionClass $reflector, string $key): bool
    {
        if (!$reflector->hasProperty($key)) {
            return true;
        }

        $property = $reflector->getProperty($key);

        if ($property->isStatic() || !$property->hasType()) {
            return true;
        }

        return false;
    }

    /**
     * @param \ReflectionClass $reflector
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    private function setPropertyValue(\ReflectionClass $reflector, string $key, $value)
    {
        $class = $this->getPropertyClass($reflector, $key);

        if (!is_null($value) && !is_null($class) && class_exists($class) && !$value instanceof $class) {
            $value = new $class($value);
        }

        $method = sprintf('set%s', ucfirst($key));

        if ($reflector->hasMethod($method)) {
            return $this->{$method}($value);
        }

        $property = $reflector->getProperty($key);
        $property->setAccessible(true);

        $property->setValue($this, $value);
    }

    /**
     * @param \ReflectionClass $reflector
     * @param string $key
     * @return string|null
     */
    private function getPropertyClass(\ReflectionClass $reflector, string $key): ?string
    {
        $property = $reflector->getProperty($key);

        if (!$property->hasType()) {
            return null;
        }

        $type = $property->getType();

        if (!$type instanceof \ReflectionNamedType) {
            return null;
        }

        return $type->getName();
    }

    /**
     * @param \ReflectionClass $reflector
     * @param string $key
     * @return mixed
     */
    private function getPropertyValue(\ReflectionClass $reflector, string $key)
    {
        $method = sprintf('get%s', ucfirst($key));

        if ($reflector->hasMethod($method)) {
            return $this->{$method}();
        }

        $property = $reflector->getProperty($key);
        $property->setAccessible(true);

        return $property->getValue($this);
    }
}
