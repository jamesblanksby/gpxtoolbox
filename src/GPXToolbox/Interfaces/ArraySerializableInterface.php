<?php

namespace GPXToolbox\Interfaces;

interface ArraySerializableInterface
{
    /**
     * Array representation data.
     * @return array<mixed>
     */
    public function toArray(): array;
}
