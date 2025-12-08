<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Xml;

class Copyright extends Xml
{
    /**
     * @inheritDoc
     */
    protected ?array $attributes = ['author',];

    /**
     * The author of the copyright.
     * @var string
     */
    public string $author = '';

    /**
     * The year of the copyright.
     * @var string|null
     */
    public ?string $year = null;

    /**
     * The license information.
     * @var string|null
     */
    public ?string $license = null;
}
