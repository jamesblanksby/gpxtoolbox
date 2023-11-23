<?php

namespace GPXToolbox\Interfaces;

interface Fillable
{
    /**
     * Fill the object with a collection.
     *
     * @param array|null $collection
     * @return $this
     */
    public function fill(?array $collection = null);
}
