<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Xml;

class Author extends Xml
{
    /**
     * @var string|null The name of the author.
     */
    public ?string $name = null;

    /**
     * @var Email|null Email address of the author.
     */
    public ?Email $email = null;

    /**
     * @var Link|null A link to additional information about the author.
     */
    public ?Link $link = null;
}
