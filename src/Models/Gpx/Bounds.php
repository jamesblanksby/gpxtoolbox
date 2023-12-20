<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Xml;

class Bounds extends Xml
{
    /**
     * @inheritDoc
     */
    protected ?array $attributes = ['minlat', 'minlon', 'maxlat', 'maxlon',];

    /**
     * @var float The minimum latitude of the bounds.
     */
    public float $minlat = 0.0;

    /**
     * @var float The minimum longitude of the bounds.
     */
    public float $minlon = 0.0;

    /**
     * @var float The maximum latitude of the bounds.
     */
    public float $maxlat = 0.0;

    /**
     * @var float The maximum longitude of the bounds.
     */
    public float $maxlon = 0.0;
}
