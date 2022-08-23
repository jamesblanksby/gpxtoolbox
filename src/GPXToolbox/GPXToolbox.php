<?php

namespace GPXToolbox;

use GPXToolbox\Parsers\ExtensionParser;
use GPXToolbox\Parsers\MetadataParser;
use GPXToolbox\Parsers\RouteParser;
use GPXToolbox\Parsers\TrackParser;
use GPXToolbox\Parsers\WaypointParser;
use GPXToolbox\Types\Extensions\TrackPointExtension;
use GPXToolbox\Types\GPX;

class GPXToolbox
{
    /**
     * GPX creator signature.
     * @var string
     */
    public const SIGNATURE = 'GPXToolbox';

    /**
     * GPX file save format.
     * @var string
     */
    public const FORMAT_GPX = 'gpx';

    /**
     * JSON file save format.
     * @var string
     */
    public const FORMAT_JSON = 'json';

    /**
     * GeoJSON file save format.
     */
    public const FORMAT_GEOJSON = 'geojson';

    /**
     * Number of decimal place precision for latitude and longitude values.
     * Six decimal places provides approximately 10cm of exactness.
     * @var integer
     */
    public static $COORDINATE_PRECISION = 6;

    /**
     * Minimum distance in meters difference between points threshold.
     * Disabled when false.
     * @var float|boolean
     */
    public static $DISTANCE_THRESHOLD = 2;

    /**
     * Number of decimal place precision for elevation values.
     * @var integer
     */
    public static $ELEVATION_PRECISION = 2;

    /**
     * Minimum elevation in meters difference between points threshold.
     * Disabled when false.
     * @var float|boolean
     */
    public static $ELEVATION_THRESHOLD = 5;

    /**
     * Minimum distance in meters to be covered
     * between points to be considered moving.
     * Used in conjuction with $MOVING_DURATION_THRESHOLD.
     * @var float
     */
    public static $MOVING_DISTANCE_THRESHOLD = 0.25;

    /**
     * Maximum duration in seconds between points to be considered moving.
     * Used in conjuction with $MOVING_DISTANCE_THRESHOLD.
     * @var float
     */
    public static $MOVING_DURATION_THRESHOLD = 5;

    /**
     * Pretty print when saving.
     * @var boolean
     */
    public static $PRETTY_PRINT = true;

    /**
     * A list of namespace extensions.
     * @var array
     */
    public static $EXTENSIONS = [];

    /**
     * GPXToolbox constructor.
     */
    public function __construct()
    {
        $this->addExtension(TrackPointExtension::class);
    }

    /**
     * Load GPX file.
     * @param string $filename
     * @return GPX
     */
    public static function load(string $filename): GPX
    {
        if (!file_exists($filename)) {
            throw new \RuntimeException('No such file');
        }

        $xml = file_get_contents($filename);

        return self::parse($xml);
    }

    /**
     * Parse GPX data string.
     * @param string $xml
     * @return GPX
     */
    public static function parse(string $xml): GPX
    {
        $data = simplexml_load_string($xml);

        $gpx = new GPX();

        $gpx->version    = isset($data['version']) ? (string) $data['version'] : null;
        $gpx->creator    = isset($data['creator']) ? (string) $data['creator'] : null;
        $gpx->metadata   = isset($data->metadata) ? MetadataParser::parse($data->metadata) : null;
        $gpx->wpt        = isset($data->wpt) ? WaypointParser::parse($data->wpt) : null;
        $gpx->rte        = isset($data->rte) ? RouteParser::parse($data->rte) : null;
        $gpx->trk        = isset($data->trk) ? TrackParser::parse($data->trk) : null;
        $gpx->extensions = isset($data->extensions) ? ExtensionParser::parse($data->extensions->children()) : null;

        return $gpx;
    }

    /**
     * Add extension to GPXToolbox.
     * @param string $extension
     * @return self
     */
    public function addExtension(string $extension): self
    {
        array_push(self::$EXTENSIONS, $extension);

        return $this;
    }
}
