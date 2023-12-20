<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Collection;

class LinkCollection extends Collection
{
    /**
     * @inheritDoc
     */
    protected ?string $class = Link::class;
}
