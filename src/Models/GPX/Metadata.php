<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Model;
use GPXToolbox\Traits\Gpx\HasLinks;

final class Metadata extends Model
{
    use HasLinks;

    public ?string $name = null;

    public ?string $desc = null;

    public ?Author $author = null;

    public ?Copyright $copyright = null;

    public LinkCollection $link;

    public ?string $time = null;

    public ?string $keywords = null;

    public ?Bounds $bounds = null;

    public function __construct(?array $collection = null)
    {
        $this->link = new LinkCollection();
        parent::__construct($collection);
    }
}
