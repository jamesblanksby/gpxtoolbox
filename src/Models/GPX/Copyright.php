<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Xml;

class Copyright extends Xml
{
    protected ?array $attributes = ['author',];

    public string $author = '';

    public ?string $year = null;

    public ?string $license = null;
}
