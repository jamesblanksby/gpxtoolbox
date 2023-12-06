<?php

namespace GPXToolbox\Models\GPX;

use GPXToolbox\Abstracts\GPX\GPXType;

final class Copyright extends GPXType
{
    /**
     * @var string The author of the copyright.
     */
    public $author = '';

    /**
     * @var string|null The year of the copyright.
     */
    public $year = null;

    /**
     * @var string|null The license associated with the copyright.
     */
    public $license = null;
}
