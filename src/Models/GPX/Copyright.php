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
     * @var string The author of the copyright.
     */
    public string $author = '';

    /**
     * @var string|null The year of the copyright.
     */
    public ?string $year = null;

    /**
     * @var string|null The license information.
     */
    public ?string $license = null;
}
