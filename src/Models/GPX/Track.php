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

    /**
     * The name of the track.
     *
     * @var string|null
     */
    public ?string $name = null;

    /**
     * A comment associated with the track.
     *
     * @var string|null
     */
    public ?string $cmt = null;

    /**
     * A description of the track.
     *
     * @var string|null
     */
    public ?string $desc = null;

    /**
     * The source of the track data.
     *
     * @var string|null
     */
    public ?string $src = null;

    /**
     * Collection of links associated with the track.
     *
     * @var LinkCollection
     */
    public LinkCollection $link;

    /**
     * The track number.
     *
     * @var int|null
     */
    public ?int $number = null;

    /**
     * The type or category of the track.
     *
     * @var string|null
     */
    public ?string $type = null;

    /**
     * Collection of track segments.
     *
     * @var SegmentCollection
     */
    public SegmentCollection $trkseg;

    /**
     * Track constructor.
     *
     * @param mixed|null $collection
     */
    public function __construct($collection = null)
    {
        $this->link = new LinkCollection();
        $this->trkseg = new SegmentCollection();
        parent::__construct($collection);
    }

    /**
     * Add a segment to the track.
     *
     * @param Segment $segment
     * @return $this
     */
    public function addSegment(Segment $segment)
    {
        $this->getPoints()->add($segment);

        return $this;
    }

    /**
     * Get the track segments.
     *
     * @return SegmentCollection
     */
    public function getSegments()
    {
        return $this->trkseg;
    }

    /**
     * Set track points using a PointCollection.
     *
     * @param PointCollection $points
     * @return $this
     */
    public function setPoints(PointCollection $points)
    {
        $segment = new Segment();
        $segment->setPoints($points);

        $this->getSegments()->clear()->add($segment);

        return $this;
    }

    /**
     * Add a single point to the track.
     *
     * @param Point $point
     * @return $this
     */
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

    /**
     * Get all track points.
     *
     * @return PointCollection
     */
    public function getPoints(): PointCollection
    {
        $points = new PointCollection();

        foreach ($this->getSegments() as $segment) {
            $points = $points->merge($segment->getPoints());
        }

        return $points;
    }

    /**
     * Get the properties of the track excluding segments.
     *
     * @return array
     */
    public function getProperties(): array
    {
        $properties = self::unwrapAttributes($this->toArray());
        unset($properties['trkseg']);

        return $properties;
    }
}
