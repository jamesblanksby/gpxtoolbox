<?php

namespace GPXToolbox\Traits;

use GPXToolbox\Abstracts\Collection;
use GPXToolbox\Interfaces\Arrayable;

trait HasArrayable
{
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
