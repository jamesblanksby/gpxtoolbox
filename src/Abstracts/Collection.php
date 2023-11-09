<?php

namespace GPXToolbox\Abstracts;

use GPXToolbox\Interfaces\Arrayable;
use GPXToolbox\Interfaces\Fillable;
use GPXToolbox\Interfaces\Iteratorable;
use GPXToolbox\Traits\HasArrayable;
use ArrayIterator;
use Countable;
use OutOfBoundsException;

abstract class Collection implements Arrayable, Countable, Fillable, Iteratorable
{
    use HasArrayable;

    /**
     * @var array The collection of items.
     */
    protected $items = [];

    /**
     * Collection constructor.
     *
     * @param array|Arrayable|null $collection
     */
    public function __construct($collection = null)
    {
        $this->fill($collection);
    }

    /**
     * Fill the collection with values.
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

        foreach ($items as $key => $value) {
            $this->set($key, $value);
        }

        return $this;
    }

    /**
     * Add a value to the collection.
     *
     * @param mixed $value
     * @return $this
     */
    public function add($value)
    {
        return $this->set(null, $value);
    }

    /**
     * Set a key-value pair in the collection.
     *
     * @param mixed $key
     * @param mixed $value
     * @return $this
     */
    public function set($key, $value)
    {
        if (isset($key)) {
            $this->items[$key] = $value;
        } else {
            $this->items[] = $value;
        }

        return $this;
    }

    /**
     * Merge the current collection with another collection.
     *
     * @param array|Arrayable $collection
     * @return static
     */
    public function merge($collection)
    {
        $items = $this->getArrayableItems($collection);

        return new static(array_merge($this->items, $items));
    }

    /**
     * Check if the collection has an item with the given key.
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
     *
     * @throws OutOfBoundsException If the key is not found in the collection.
     */
    public function get($key)
    {
        if (!$this->has($key)) {
            throw new OutOfBoundsException(sprintf('Missing collection item: %s', $key));
        }

        return $this->items[$key];
    }

    /**
     * Get all items from the collection.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->items;
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
     * Get the first item in the collection.
     *
     * @return mixed
     */
    public function first()
    {
        return $this->reset()->current();
    }

    /**
     * Get the last item in the collection.
     *
     * @return mixed
     */
    public function last()
    {
        return end($this->items);
    }

    /**
     * Get the current item in the collection.
     *
     * @return mixed
     */
    public function current()
    {
        return current($this->items);
    }

    /**
     * Count the number of items in the collection.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->items);
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
        return new static(array_slice($this->items, $offset, $length, true));
    }

    /**
     * Get an iterator for the collection.
     *
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
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
            if ($value instanceof Arrayable) {
                $value = $value->toArray();
            }

            $array[$key] = $value;
        }

        return $array;
    }
}
