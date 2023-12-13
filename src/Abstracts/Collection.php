<?php

namespace GPXToolbox\Abstracts;

use GPXToolbox\Interfaces\Arrayable;
use GPXToolbox\Interfaces\Fillable;
use GPXToolbox\Interfaces\Iteratorable;
use GPXToolbox\Traits\HasArrayable;

abstract class Collection implements Arrayable, \Countable, Fillable, Iteratorable
{
    use HasArrayable;

    protected ?string $class = null;

    protected array $items = [];

    final public function __construct($collection = null)
    {
        $this->fill($collection);
    }

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

    public function clear()
    {
        $this->items = [];

        return $this;
    }

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

    public function add($value)
    {
        return $this->set(null, $value);
    }

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

    public function all(): array
    {
        return $this->items;
    }

    public function has($key): bool
    {
        return isset($this->items[$key]);
    }

    public function get($key)
    {
        return $this->items[$key];
    }

    public function reset()
    {
        reset($this->items);

        return $this;
    }

    public function first()
    {
        return $this->reset()->current();
    }

    public function last()
    {
        return end($this->items);
    }

    public function current()
    {
        return current($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function map(callable $callback)
    {
        return new static(array_map($callback, $this->items));
    }

    public function merge($collection)
    {
        $items = $this->getArrayableItems($collection);

        return new static(array_merge($this->items, $items));
    }

    public function slice(int $offset, ?int $length = null)
    {
        return new static(array_slice($this->items, $offset, $length, true));
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->items);
    }

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
