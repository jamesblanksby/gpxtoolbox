<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Xml;
use GPXToolbox\Traits\Gpx\HasLinks;

class Metadata extends Xml
{
    use HasLinks;

    /**
     * The name of the GPX file.
     * @var string|null
     */
    public ?string $name = null;

    /**
     * A description of the GPX file.
     * @var string|null
     */
    public ?string $desc = null;

    /**
     * The author of the GPX file.
     * @var Author|null
     */
    public ?Author $author = null;

    /**
     * Copyright information for the GPX file.
     * @var Copyright|null
     */
    public ?Copyright $copyright = null;

    /**
     * A collection of links associated with the GPX file.
     * @var LinkCollection
     */
    public LinkCollection $link;

    /**
     * The timestamp of when the GPX file was created.
     * @var Datetime|null
     */
    public ?Datetime $time = null;

    /**
     * Keywords associated with the GPX file.
     * @var string|null
     */
    public ?string $keywords = null;

    /**
     * Bounding box information for the GPX file.
     * @var Bounds|null
     */
    public ?Bounds $bounds = null;

    /**
     * Metadata constructor.
     *
     * @param array|null $collection
     */
    public function __construct(?array $collection = null)
    {
        $this->link = new LinkCollection();
        parent::__construct($collection);
    }
}
