<?php

namespace GPXToolbox\Types\Extensions;

use GPXToolbox\Helpers\SerializationHelper;
use GPXToolbox\Parsers\Extensions\TrackPointV1ExtensionParser;

class TrackPointV1Extension extends ExtensionAbstract
{
    /**
     * @inheritDoc
     */
    public static $EXTENSION_NAME = 'TrackPointExtension';

    /**
     * @inheritDoc
     */
    public static $EXTENSION_PREFIX = 'gpxtx';

    /**
     * @inheritDoc
     */
    public static $EXTENSION_NAMESPACE = 'http://www.garmin.com/xmlschemas/TrackPointExtension/v1';

    /**
     * @inheritDoc
     */
    public static $EXTENSION_SCHEMA = 'http://www.garmin.com/xmlschemas/TrackPointExtensionv1.xsd';

    /**
     * @inheritDoc
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
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return SerializationHelper::filterNotNull([
            'atemp'   => $this->atemp,
            'wtemp'   => $this->wtemp,
            'depth'   => $this->depth,
            'hr'      => $this->hr,
            'cad'     => $this->cad,
        ]);
    }
}
