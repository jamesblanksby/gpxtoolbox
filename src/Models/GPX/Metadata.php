<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Xml;
use GPXToolbox\Traits\Gpx\HasLinks;

class Metadata extends Xml
{
    use HasLinks;

    /**
     * @var string|null The name of the GPX file.
     */
    public ?string $name = null;

    /**
     * @var string|null A description of the GPX file.
     */
    public ?string $desc = null;

    /**
     * @var Author|null The author of the GPX file.
     */
    public ?Author $author = null;

    /**
     * @var Copyright|null Copyright information for the GPX file.
     */
    public ?Copyright $copyright = null;

    /**
     * @var LinkCollection A collection of links associated with the GPX file.
     */
    public LinkCollection $link;

    /**
     * @var Datetime|null The timestamp of when the GPX file was created.
     */
    public ?Datetime $time = null;

    /**
     * @var string|null Keywords associated with the GPX file.
     */
    public ?string $keywords = null;

    /**
     * @var Bounds|null Bounding box information for the GPX file.
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
