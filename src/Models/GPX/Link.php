<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Xml;

final class Link extends Xml
{
    protected ?array $attributes = ['href',];

    public string $href = '';

    public ?string $text = null;

    public ?string $type = null;
}
