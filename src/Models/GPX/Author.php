<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Model;

final class Author extends Model
{
    public ?string $name = null;

    public ?Email $email = null;

    public ?Link $link = null;
}
