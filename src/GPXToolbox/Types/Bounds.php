<?php

namespace GPXToolbox\Types;

use GPXToolbox\Interfaces\ArraySerializableInterface;

class Bounds implements ArraySerializableInterface
{
    /**
     * The minimum latitude.
     * @var float
     */
    public $minlat = 0.0;

    /**
     * The minimum longitude.
     * @var float
     */
    public $minlon = 0.0;

    /**
     * The maximum latitude.
     * @var float
     */
    public $maxlat = 0.0;

    /**
     * The maximum longitude.
     * @var float
     */
    public $maxlon = 0.0;

    /**
     * Array representation of bounds data.
     * @return float[]
     */
    public function toArray(): array
    {
        return [
            'minlat' => $this->minlat,
            'minlon' => $this->minlon,
            'maxlat' => $this->maxlat,
            'maxlon' => $this->maxlon,
        ];
    }
}
