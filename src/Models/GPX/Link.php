<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Model;

final class Link extends Model
{
    public string $href = '';

    public ?string $text = null;

    public ?string $type = null;
}
