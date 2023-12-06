<?php

namespace GPXToolbox\Models\GPX;

use GPXToolbox\Abstracts\GPX\GPXType;
use GPXToolbox\Traits\GPX\HasLinks;
use GPXToolbox\Traits\GPX\HasPoints;
use GPXToolbox\Traits\GPX\HasStatistics;

final class Track extends GPXType
{
    use HasLinks;
    use HasPoints;
    use HasStatistics;

    /**
     * @var string|null The name of the track.
     */
    public $name = null;

    /**
     * @var string|null The comment associated with the track.
     */
    public $cmt = null;

    /**
     * @var string|null The description of the track.
     */
    public $desc = null;

    /**
     * @var string|null The source of the track data.
     */
    public $src = null;

    /**
     * @var LinkCollection A list of links associated with the track.
     */
    public $link;

    /**
     * @var null|int The track number.
     */
    public $number = null;

    /**
     * @var string|null The type or category of the track.
     */
    public $type = null;

    /**
     * @var SegmentCollection A list of track segments associated with the track.
     */
    public $trkseg;

    /**
     * Segment constructor.
     *
     * @param array|null $collection
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
     * @param Segment $segment The segment to add.
     * @return $this
     */
    public function addSegment(Segment $segment)
    {
        $this->getPoints()->add($segment);

        return $this;
    }

    /**
     * Get a list of segments associated with the track.
     *
     * @return SegmentCollection
     */
    public function getSegments()
    {
        return $this->trkseg;
    }

    /**
     * Add a point to the track.
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
            $points = new PointCollection();
            $points->addPoint($point);

            $this->setPoints($points);
        }

        return $this;
    }

    /**
     * Set a list of points associated with the track.
     *
     * @param PointCollection $points
     * @return $this
     */
    public function setPoints(PointCollection $points)
    {
        $segments = $this->getSegments();

        $segments->clear();

        $segment = new Segment();
        $segment->setPoints($points);

        $segments->add($segment);

        return $this;
    }

    /**
     * Get a list of points associated with the track.
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
}
