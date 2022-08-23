<?php

namespace GPXToolbox\Types\Extensions;

use GPXToolbox\Parsers\Extensions\TrackPointExtensionParser;

class TrackPointExtension implements ExtensionInterface
{
    /**
     * Name of extension.
     * @var string
     */
    public const EXTENSION_NAME = 'TrackPointExtension';

    /**
     * XML namespace of extension.
     * @var string|array
     */
    public const EXTENSION_NAMESPACE = [
        'http://www.garmin.com/xmlschemas/TrackPointExtension/v1',
        'http://www.garmin.com/xmlschemas/TrackPointExtension/v2',
    ];

    /**
     * Extension parser fully qualified class name.
     * @var string
     */
    public const EXTENSION_PARSER = TrackPointExtensionParser::class;

    /**
     * Air temperature in degrees Celsius.
     * @var float|null
     */
    public $atemp = null;

    /**
     * Water temperature in degrees Celsius.
     * @var float|null
     */
    public $wtemp = null;

    /**
     * Water depth in meters.
     * @var float|null
     */
    public $depth = null;

    /**
     * Heart rate in beats per minute.
     * @var integer|null
     */
    public $hr = null;

    /**
     * Cadence in revolutions per minute.
     * @var integer|null
     */
    public $cad = null;

    /**
     * Speed in meters per second.
     * @var float|null
     */
    public $speed = null;

    /**
     * Course angle measured in degrees.
     * @var float|null
     */
    public $course = null;

    /**
     * Bearing angle measured in degrees.
     * @var float|null
     */
    public $bearing = null;

    /**
     * Array representation of track point extension data.
     * @return array
     */
    public function toArray(): array
    {
        return [
            'atemp' => $this->atemp,
            'wtemp' => $this->wtemp,
            'depth' => $this->depth,
            'hr' => $this->hr,
            'cad' => $this->cad,
            'speed' => $this->speed,
            'course' => $this->course,
            'bearing' => $this->bearing,
        ];
    }
}
