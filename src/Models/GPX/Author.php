<?php

namespace GPXToolbox\Models\GPX;

use GPXToolbox\Abstracts\GPX\GPXType;

class Author extends GPXType
{
    /**
     * @var string|null The name of the author.
     */
    public $name = null;

    /**
     * @var Email|null The email address of the author.
     */
    public $email = null;

    /**
     * @var Link|null A link associated with the author.
     */
    public $link = null;
}
