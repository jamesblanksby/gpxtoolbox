<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Model;

final class Copyright extends Model
{
    public string $author = '';

    public ?string $year = null;

    public ?string $license = null;
}
