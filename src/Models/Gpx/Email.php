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
     * The local part of the email address.
     * @var string
     */
    public string $id = '';

    /**
     * The domain part of the email address.
     * @var string
     */
    public string $domain = '';
}
