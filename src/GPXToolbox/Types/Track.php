<?php

namespace GPXToolbox\Types;

use GPXToolbox\Helpers\GeoHelper;
use GPXToolbox\Helpers\SerializationHelper;
use GPXToolbox\Helpers\StatsHelper;
use GPXToolbox\Models\Stats;
use GPXToolbox\Types\Extensions\ExtensionAbstract;

class Track
{
    /**
     * GPS name of track.
     * @var string|null
     */
    public $name = null;

    /**
     * GPS comment for track.
     * @var string|null
     */
    public $cmt = null;

    /**
     * User description of track.
     * @var string|null
     */
    public $desc = null;

    /**
     * Source of data.
     * Included to give user some idea of reliability and accuracy of data.
     * @var string|null
     */
    public $src = null;

    /**
     * Links to external information about track.
     * @var Link[]|null
     */
    public $links = null;

    /**
     * GPS track number.
     * @var integer|null
     */
    public $number = null;

    /**
     * Type (classification) of track.
     * @var string|null
     */
    public $type = null;

    /**
     * A list of extensions.
     * @var ExtensionAbstract[]
     */
    public $extensions = [];

    /**
     * A Track Segment holds a list of Track Points
     * which are logically connected in order.
     * @var Segment[]|null
     */
    public $trkseg = null;

    /**
     * Add link to track.
     * @param Link $link
     * @return self
    */
    public function addLink(Link $link): self
    {
        array_push($this->links, $link);

        return $this;
    }

    /**
     * Add extension to track.
     * @param ExtensionAbstract $extension
     * @return self
    */
    public function addExtension(ExtensionAbstract $extension): self
    {
        array_push($this->extensions, $extension);

        return $this;
    }

    /**
     * Add segment to track.
     * @param Segment $segment
     * @return self
    */
    public function addSegment(Segment $segment): self
    {
        array_push($this->trkseg, $segment);

        return $this;
    }

    /**
     * Recursively gather Track points.
     * @return array
     */
    public function getPoints(): array
    {
        $points = [];

        if (is_null($this->trkseg)) {
            return $points;
        }

        foreach ($this->trkseg as $trkseg) {
            $points = array_merge($points, $trkseg->getPoints());
        }

        return $points;
    }

    /**
     * Calculate Track bounds.
     * @return array
     */
    public function getBounds(): array
    {
        $points = $this->getPoints();
        $bounds = GeoHelper::getBounds($points);

        return $bounds;
    }

    /**
     * Calculate Track stats.
     * @return Stats
     */
    public function getStats(): Stats
    {
        $points = $this->getPoints();
        $stats = StatsHelper::calculateStats($points);

        return $stats;
    }

    /**
     * Simplify path by removing extra points with given tolerance.
     * @param float $tolerance
     * @param boolean $highestQuality
     * @return Track
     */
    public function simplify(float $tolerance = 1.0, bool $highestQuality = false): Track
    {
        if (is_null($this->trkseg)) {
            return $this;
        }

        foreach ($this->trkseg as &$trkseg) {
            $trkseg->simplify($tolerance, $highestQuality);
        }

        return $this;
    }

    /**
     * Array representation of track data.
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name'       => $this->name,
            'cmt'        => $this->cmt,
            'desc'       => $this->desc,
            'src'        => $this->src,
            'links'      => SerializationHelper::toArray($this->links),
            'number'     => $this->number,
            'type'       => $this->type,
            'extensions' => SerializationHelper::toArray($this->extensions),
            'trkseg'     => SerializationHelper::toArray($this->trkseg),
        ];
    }
}
