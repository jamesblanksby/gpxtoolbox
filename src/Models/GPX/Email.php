<?php

namespace GPXToolbox\Models\GPX;

use GPXToolbox\Abstracts\GPX\GPXType;

final class Email extends GPXType
{
    /**
     * @var string The identifier part of the email address.
     */
    public $id = '';

    /**
     * @var string The domain part of the email address.
     */
    public $domain = '';
}
