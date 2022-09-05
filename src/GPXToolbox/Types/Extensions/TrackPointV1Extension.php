<?php

namespace GPXToolbox\Types\Extensions;

use GPXToolbox\Parsers\Extensions\TrackPointV1ExtensionParser;

class TrackPointV1Extension extends ExtensionAbstract
{
    /**
     * @inheritDoc
     * @var string
     */
    public static $EXTENSION_NAME = 'TrackPointExtension';

    /**
     * @inheritDoc
     * @var string
     */
    public static $EXTENSION_PREFIX = 'gpxtx';

    /**
     * @inheritDoc
     * @var string
     */
    public static $EXTENSION_NAMESPACE = 'http://www.garmin.com/xmlschemas/TrackPointExtension/v1';

    /**
     * @inheritDoc
     * @var string
     */
    public static $EXTENSION_SCHEMA = 'http://www.garmin.com/xmlschemas/TrackPointExtensionv1.xsd';

    /**
     * @inheritDoc
     * @var string
     */
    public static $EXTENSION_PARSER = TrackPointV1ExtensionParser::class;

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
     * @inheritDoc
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
        ];
    }
}
