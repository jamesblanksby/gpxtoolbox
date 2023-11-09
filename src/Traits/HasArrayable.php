<?php

namespace GPXToolbox\Traits;

use GPXToolbox\Abstracts\Collection;
use GPXToolbox\Interfaces\Arrayable;

trait HasArrayable
{
    /**
     * Get the arrayable items from the given collection.
     *
     * @param mixed $collection
     *
     * @return array
     */
    protected function getArrayableItems($collection)
    {
        if ($collection instanceof Collection) {
            $items = $collection->all();
        } elseif ($collection instanceof Arrayable) {
            $items = $collection->toArray();
        } else {
            $items = (array) $collection;
        }

        return $items;
    }
}
