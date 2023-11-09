<?php

namespace GPXToolbox\Interfaces;

interface Fillable
{
    /**
     * Fill the object with a collection.
     *
     * @param array|null $collection
     */
    public function fill(?array $collection = null);
}
