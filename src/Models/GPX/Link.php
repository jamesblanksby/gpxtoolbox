<?php

namespace GPXToolbox\Models\GPX;

use GPXToolbox\Abstracts\GPX\GPXType;

class Link extends GPXType
{
    /**
     * @var string The hyperlink reference.
     */
    public $href = '';

    /**
     * @var string|null he text of the hyperlink.
     */
    public $text = null;

    /**
     * @var string|null The type of the hyperlink.
     */
    public $type = null;
}
