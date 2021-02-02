<?php

namespace GPXToolbox\Types;

use GPXToolbox\Helpers\SerializationHelper;

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
     * @var int|null
     */
    public $number = null;

    /**
     * Type (classification) of track.
     * @var string|null
     */
    public $type = null;

    /**
     * A Track Segment holds a list of Track Points
     * which are logically connected in order.
     * @var Segment[]|null
     */
    public $trkseg = null;

    /**
     * Simplify path by removing extra points with given tolerance.
     * @param float $tolerance
     * @param boolean $highestQuality
     * @return Track
     */
    public function simplify(float $tolerance = 1.0, bool $highestQuality = false) : Track
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
    public function toArray() : array
    {
        return [
            'name'   => $this->name,
            'cmt'    => $this->cmt,
            'desc'   => $this->desc,
            'src'    => $this->src,
            'links'  => SerializationHelper::toArray($this->links),
            'number' => $this->number,
            'type'   => $this->type,
            'trkseg' => SerializationHelper::toArray($this->trkseg),
        ];
    }
}
