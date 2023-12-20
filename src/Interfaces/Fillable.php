<?php

namespace GPXToolbox\Interfaces;

interface Fillable
{
    /**
     * Fill the object with data.
     *
     * @param mixed $collection
     */
    public function fill($collection = null);
}
