<?php

namespace GPXToolbox\Types\Extensions;

use GPXToolbox\Parsers\Extensions\TrackPointV2ExtensionParser;

class TrackPointV2Extension implements ExtensionInterface
{
    /**
     * Name of extension.
     * @var string
     */
    public const EXTENSION_NAME = 'TrackPointExtension';

    /**
     * Name of extension prefix
     * @var string|null
     */
    public const EXTENSION_PREFIX = 'gpxtx';

    /**
     * XML namespace of extension.
     * @var string
     */
    public const EXTENSION_NAMESPACE = 'http://www.garmin.com/xmlschemas/TrackPointExtension/v2';

    /**
     * XML schema definition.
     * @var string
     */
    public const EXTENSION_SCHEMA = 'http://www.garmin.com/xmlschemas/TrackPointExtensionv2.xsd';

    /**
     * Extension parser fully qualified class name.
     * @var string
     */
    public const EXTENSION_PARSER = TrackPointV2ExtensionParser::class;

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
            'atemp'   => $this->atemp,
            'wtemp'   => $this->wtemp,
            'depth'   => $this->depth,
            'hr'      => $this->hr,
            'cad'     => $this->cad,
            'speed'   => $this->speed,
            'course'  => $this->course,
            'bearing' => $this->bearing,
        ];
    }
}
