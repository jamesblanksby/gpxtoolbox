<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Xml;

class Bounds extends Xml
{
    protected ?array $attributes = ['minlat', 'minlon', 'maxlat', 'maxlon',];

    public float $minlat = 0.0;

    public float $minlon = 0.0;

    public float $maxlat = 0.0;

    public float $maxlon = 0.0;
}
