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
     * The minimum latitude of the bounds.
     * @var float
     */
    public float $minlat = 0.0;

    /**
     * The minimum longitude of the bounds.
     * @var float
     */
    public float $minlon = 0.0;

    /**
     * The maximum latitude of the bounds.
     * @var float
     */
    public float $maxlat = 0.0;

    /**
     * The maximum longitude of the bounds.
     * @var float
     */
    public float $maxlon = 0.0;
}
