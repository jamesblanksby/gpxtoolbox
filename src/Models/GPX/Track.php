<?php

namespace GPXToolbox\Models\Gpx;

use GPXToolbox\Abstracts\Xml;
use GPXToolbox\Traits\Gpx\HasLinks;
use GPXToolbox\Traits\Gpx\HasPoints;
use GPXToolbox\Traits\Gpx\HasStatistics;

class Track extends Xml
{
    use HasLinks;
    use HasPoints;
    use HasStatistics;

    public ?string $name = null;

    public ?string $cmt = null;

    public ?string $desc = null;

    public ?string $src = null;

    public LinkCollection $link;

    public ?int $number = null;

    public ?string $type = null;

    public SegmentCollection $trkseg;

    public function __construct($collection = null)
    {
        $this->link = new LinkCollection();
        $this->trkseg = new SegmentCollection();
        parent::__construct($collection);
    }

    public function addSegment(Segment $segment)
    {
        $this->getPoints()->add($segment);

        return $this;
    }

    public function getSegments()
    {
        return $this->trkseg;
    }

    public function setPoints(PointCollection $points)
    {
        $segment = new Segment();
        $segment->setPoints($points);

        $this->getSegments()->clear()->add($segment);

        return $this;
    }

    public function addPoint(Point $point)
    {
        $segment = $this->getSegments()->first();

        if ($segment) {
            $segment->add($point);
        } else {
            $points = new PointCollection([$point,]);
            $this->setPoints($points);
        }

        return $this;
    }

    public function getPoints(): PointCollection
    {
        $points = new PointCollection();

        foreach ($this->getSegments() as $segment) {
            $points = $points->merge($segment->getPoints());
        }

        return $points;
    }

    public function getProperties(): array
    {
        $properties = self::unwrapAttributes($this->toArray());
        unset($properties['trkseg']);

        return $properties;
    }
}
