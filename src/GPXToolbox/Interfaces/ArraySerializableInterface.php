<?php

namespace GPXToolbox\Interfaces;

interface ArraySerializableInterface
{
    /**
     * Array representation data.
     * @return mixed[]
     */
    public function toArray(): array;
}
