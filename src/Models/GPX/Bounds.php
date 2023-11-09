<?php

namespace GPXToolbox\Models\GPX;

use GPXToolbox\Abstracts\GPX\GPXType;

class Bounds extends GPXType
{
    /**
     * @var float Minimum latitude of the bounds.
     */
    public $minlat = 0.0;

    /**
     * @var float Minimum longitude of the bounds.
     */
    public $minlon = 0.0;

    /**
     * @var float Maximum latitude of the bounds.
     */
    public $maxlat = 0.0;

    /**
     * @var float Maximum longitude of the bounds.
     */
    public $maxlon = 0.0;
}
