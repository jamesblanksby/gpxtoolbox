<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Model;

final class Bounds extends Model
{
    public float $minlat = 0.0;

    public float $minlon = 0.0;

    public float $maxlat = 0.0;

    public float $maxlon = 0.0;
}
