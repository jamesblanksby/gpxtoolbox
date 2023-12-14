<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Xml;
use GPXToolbox\Traits\Gpx\HasLinks;
use GPXToolbox\Traits\Gpx\HasPoints;

final class Route extends Xml
{
    use HasLinks;
    use HasPoints;

    public ?string $name = null;

    public ?string $cmt = null;

    public ?string $desc = null;

    public ?string $src = null;

    public LinkCollection $link;

    public ?int $number = null;

    public ?string $type = null;

    public PointCollection $rtept;

    public function __construct($collection = null)
    {
        $this->link = new LinkCollection();
        $this->rtept = new PointCollection();
        parent::__construct($collection);
    }

    public function getPoints(): PointCollection
    {
        return $this->rtept;
    }

    public function getProperties(): array
    {
        $properties = self::unwrapAttributes($this->toArray());
        unset($properties['rtept']);

        return $properties;
    }
}
