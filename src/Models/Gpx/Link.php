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
     * The URL of the link.
     * @var string
     */
    public string $href = '';

    /**
     * The text of the link.
     * @var string|null
     */
    public ?string $text = null;

    /**
     * The type of the link.
     * @var string|null
     */
    public ?string $type = null;
}
