<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Xml;

class Author extends Xml
{
    public ?string $name = null;

    public ?Email $email = null;

    public ?Link $link = null;
}
