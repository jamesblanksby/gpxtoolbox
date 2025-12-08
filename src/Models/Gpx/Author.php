<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Xml;

class Author extends Xml
{
    /**
     * The name of the author.
     * @var string|null
     */
    public ?string $name = null;

    /**
     * Email address of the author.
     * @var Email|null
     */
    public ?Email $email = null;

    /**
     * A link to additional information about the author.
     * @var Link|null
     */
    public ?Link $link = null;
}
