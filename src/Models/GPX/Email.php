<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Xml;

final class Email extends Xml
{
    protected ?array $attributes = ['id', 'domain',];

    public string $id = '';

    public string $domain = '';
}
