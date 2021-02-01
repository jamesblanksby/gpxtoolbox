<?php

namespace GPXToolbox;

use GPXToolbox\Types\GPX;
use GPXToolbox\Parsers\MetadataParser;
use GPXToolbox\Parsers\WaypointParser;
use GPXToolbox\Parsers\RouteParser;
use GPXToolbox\Parsers\TrackParser;

class GPXToolbox
{
    /**
     * GPX creator signature.
     * @var string
     */
    const SIGNATURE = 'GPXToolbox';
    
    /**
     * GPX file save format.
     * @var string
     */
    const FORMAT_GPX = 'gpx';

    /**
     * JSON file save format.
     * @var string
     */
    const FORMAT_JSON = 'json';

    /**
     * Pretty print when saving.
     * @var boolean
     */
    public static $PRETTY_PRINT = true;

    /**
     * Load GPX file.
     * @param string $filename
     * @return GPX
     */
    public static function load(string $filename) : GPX
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
    public static function parse(string $xml) : GPX
    {
        $data = simplexml_load_string($xml);

        $gpx = new GPX();

        $gpx->metadata = isset($data->metadata) ? MetadataParser::parse($data->metadata) : null;
        $gpx->wpt      = isset($data->wpt) ? WaypointParser::parse($data->wpt) : null;
        $gpx->rte      = isset($data->rte) ? RouteParser::parse($data->rte) : null;
        $gpx->trk      = isset($data->trk) ? TrackParser::parse($data->trk) : null;
        $gpx->version  = isset($data['version']) ? (string) $data['version'] : null;
        $gpx->creator  = isset($data['creator']) ? (string) $data['creator'] : null;

        return $gpx;
    }
}
