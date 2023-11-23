<?php

namespace GPXToolbox\Models\GPX;

use GPXToolbox\Abstracts\GPX\GPXType;
use GPXToolbox\Traits\GPX\HasLinks;
use DateTime;

class Metadata extends GPXType
{
    use HasLinks;

    /**
     * @var string|null The name of the GPX file.
     */
    public $name = null;

    /**
     * @var string|null A description of the GPX file.
     */
    public $desc = null;

    /**
     * @var Author|null The author of the GPX file.
     */
    public $author = null;

    /**
     * @var Copyright|null Copyright information related to the GPX file.
     */
    public $copyright = null;

    /**
     * @var LinkCollection A list of links associated with the GPX file.
     */
    public $link;

    /**
     * @var DateTime|null The time associated with the GPX file.
     */
    public $time = null;

    /**
     * @var string|null Keywords related to the GPX file.
     */
    public $keywords = null;

    /**
     * @var Bounds|null Geographic bounds associated with the GPX file.
     */
    public $bounds = null;

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
