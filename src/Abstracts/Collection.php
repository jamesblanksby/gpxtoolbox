<?php

namespace GPXToolbox\Abstracts;

use GPXToolbox\Interfaces\Arrayable;
use GPXToolbox\Interfaces\Fillable;
use GPXToolbox\Interfaces\Iteratorable;
use GPXToolbox\Serializers\ObjectSerializer;
use GPXToolbox\Traits\HasArrayable;

abstract class Collection implements Arrayable, \Countable, Fillable, Iteratorable
{
    use HasArrayable;

    /**
     * @var string|null The class name used for hydration.
     */
    protected ?string $class = null;

    /**
     * @var array The collection items.
     */
    protected array $items = [];

    /**
     * Collection constructor.
     *
     * @param mixed $collection
     */
    final public function __construct($collection = null)
    {
        $this->fill($collection);
    }

    /**
     * Fill the collection with data.
     *
     * @param mixed $collection
     * @return $this
     */
    public function fill($collection = null)
    {
        if (is_null($collection)) {
            return $this;
        }

        $items = $this->getArrayableItems($collection);

        if (!array_is_list($items)) {
            $items = [$items,];
        }

        foreach ($items as $key => $value) {
            $this->set($key, $value);
        }

        return $this;
    }

    /**
     * Clear all items from the collection.
     *
     * @return $this
     */
    public function clear()
    {
        $this->items = [];

        return $this;
    }

    /**
     * Set an item in the collection by key.
     *
     * @param mixed $key
     * @param mixed $value
     * @return $this
     */
    public function set($key, $value)
    {
        $value = $this->hydrate($value);

        if (isset($key)) {
            $this->items[$key] = $value;
        } else {
            $this->items[] = $value;
        }

        return $this;
    }

    /**
     * Add an item to the collection.
     *
     * @param mixed $value
     * @return $this
     */
    public function add($value)
    {
        return $this->set(null, $value);
    }

    /**
     * Hydrate a value based on the configured class.
     *
     * @param mixed $value
     * @return mixed
     */
    public function hydrate($value)
    {
        if (is_null($this->class)) {
            return $value;
        }

        if (!is_array($value)) {
            return $value;
        }

        return new $this->class($value);
    }

    /**
     * Get all items in the collection.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->items;
    }

    /**
     * Check if an item exists in the collection.
     *
     * @param mixed $key
     * @return bool
     */
    public function has($key): bool
    {
        return isset($this->items[$key]);
    }

    /**
     * Get an item from the collection by key.
     *
     * @param mixed $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->items[$key];
    }

    /**
     * Reset the internal pointer of the collection to the first element.
     *
     * @return $this
     */
    public function reset()
    {
        reset($this->items);

        return $this;
    }

    /**
     * Get the first element of the collection.
     *
     * @return mixed
     */
    public function first()
    {
        return $this->reset()->current();
    }

    /**
     * Get the last element of the collection.
     *
     * @return mixed
     */
    public function last()
    {
        return end($this->items);
    }

    /**
     * Get the current element in the collection.
     *
     * @return mixed
     */
    public function current()
    {
        return current($this->items);
    }

    /**
     * Get the number of items in the collection.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * Map over each item in the collection.
     *
     * @param callable $callback
     * @return static
     */
    public function map(callable $callback)
    {
        return new static(array_map($callback, $this->items));
    }

    /**
     * Merge the collection with another array or collection.
     *
     * @param mixed $collection
     * @return static
     */
    public function merge($collection)
    {
        $items = $this->getArrayableItems($collection);

        return new static(array_merge($this->items, $items));
    }

    /**
     * Extract a slice of the collection.
     *
     * @param int $offset
     * @param int|null $length
     * @return static
     */
    public function slice(int $offset, ?int $length = null)
    {
        return new static(array_slice($this->items, $offset, $length));
    }

    /**
     * Get an external iterator for the collection.
     *
     * @return \ArrayIterator
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->items);
    }

    /**
     * Convert the collection to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        $array = [];

        foreach ($this->items as $key => $value) {
            if (is_object($value)) {
                $value = ObjectSerializer::serialize($value);
            }

            $array[$key] = $value;
        }

        return $array;
    }
}
