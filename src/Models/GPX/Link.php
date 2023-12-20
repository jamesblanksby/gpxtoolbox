<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Xml;

class Link extends Xml
{
    /**
     * @inheritDoc
     */
    protected ?array $attributes = ['href',];

    /**
     * @var string The URL of the link.
     */
    public string $href = '';

    /**
     * @var string|null The text of the link.
     */
    public ?string $text = null;

    /**
     * @var string|null The type of the link.
     */
    public ?string $type = null;
}
