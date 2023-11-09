<?php

namespace GPXToolbox\Interfaces;

interface Jsonable
{
    /**
     * Convert the object to a JSON string.
     *
     * @param int $options
     * @return string
     */
    public function toJson(int $options = 0): string;
}
