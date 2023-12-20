<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Xml;

class Email extends Xml
{
    /**
     * @inheritDoc
     */
    protected ?array $attributes = ['id', 'domain',];

    /**
     * @var string The local part of the email address.
     */
    public string $id = '';

    /**
     * @var string The domain part of the email address.
     */
    public string $domain = '';
}
