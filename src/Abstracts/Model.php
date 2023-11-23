<?php

namespace GPXToolbox\Abstracts;

use GPXToolbox\Interfaces\Arrayable;
use GPXToolbox\Interfaces\Fillable;
use GPXToolbox\Interfaces\Jsonable;
use GPXToolbox\Traits\HasArrayable;
use ReflectionClass;
use ReflectionNamedType;

abstract class Model implements Arrayable, Fillable, Jsonable
{
    use HasArrayable;

    /**
     * Model constructor.
     *
     * @param array|Arrayable|null $collection
     */
    public function __construct($collection = null)
    {
        $this->fill($collection);
    }

    /**
     * Fill the model with values.
     *
     * @param array|Arrayable|null $collection
     * @return $this
     */
    public function fill($collection = null)
    {
        if (is_null($collection)) {
            return $this;
        }

        $items = $this->getArrayableItems($collection);

        $reflector = new ReflectionClass($this);

        foreach ($items as $key => $value) {
            $property = $reflector->getProperty($key);
            $property->setAccessible(true);

            if ($property->hasType()) {
                $type = $property->getType();

                if (!$type instanceof ReflectionNamedType) {
                    continue;
                }

                $class = $type->getName();
                if (class_exists($class) && (!is_object($value) || get_class($value) !== $class)) {
                    $value = new $class(...$value);
                }
            }

            $property->setValue($this, $value);
        }

        return $this;
    }

    /**
     * Get the model's attributes as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        $array = [];

        $reflector = new ReflectionClass($this);

        foreach ($reflector->getProperties() as $property) {
            if ($property->isStatic()) {
                continue;
            }

            $property->setAccessible(true);
            $value = $property->getValue($this);

            if ($value instanceof Arrayable) {
                $value = $value->toArray();
            }

            $array[$property->getName()] = $value;
        }

        return $array;
    }

    /**
     * Convert the model's attributes to JSON.
     *
     * @param int $options
     * @return string
     */
    public function toJson(int $options = 0): string
    {
        return json_encode($this->serializeJson(), $options);
    }

    /**
     * Serialize the model's attributes for JSON.
     *
     * @return array
     */
    public function serializeJson()
    {
        return $this->toArray();
    }
}
