<?php

namespace GPXToolbox\Types;

use GPXToolbox\Parsers\MetadataParser;
use GPXToolbox\Parsers\WaypointParser;
use GPXToolbox\Parsers\RouteParser;
use GPXToolbox\Parsers\TrackParser;
use GPXToolbox\Helpers\SerializationHelper;
use GPXToolbox\Helpers\GeoJSONHelper;
use GPXToolbox\GPXToolbox;

class GPX
{
    /**
     * Metadata about the file.
     * @var Metadata|null
     */
    public $metadata = null;

    /**
     * A list of way points.
     * @var Waypoint[];
     */
    public $wpt = [];

    /**
     * A list of routes.
     * @var Route[]
     */
    public $rte = [];

    /**
     * A list of tracks.
     * @var Track[]
     */
    public $trk = [];

    /**
     * Version of the file.
     * @var string
     */
    public $version = '';

    /**
     * Creator of the file.
     * @var string
     */
    public $creator = '';

    /**
     * Simplify path by removing extra points with given tolerance.
     * @param float $tolerance
     * @param boolean $highestQuality
     * @return GPX
     */
    public function simplify(float $tolerance = 1.0, bool $highestQuality = false) : GPX
    {
        if (is_null($this->trk)) {
            return $this;
        }

        foreach ($this->trk as &$trk) {
            $trk->simplify($tolerance, $highestQuality);
        }

        return $this;
    }

    /**
     * Save GPX to file.
     * @param string $path
     * @param string $format
     * @return boolean
     */
    public function save(string $path, string $format) : bool
    {
        switch ($format) {
            case GPXToolbox::FORMAT_GPX:
                $doc = $this->toXML();
                return $doc->save($path);
            break;
            case GPXToolbox::FORMAT_JSON:
                $json = $this->toJSON();
                return file_put_contents($path, $json);
            break;
            case GPXToolbox::FORMAT_GEOJSON:
                $geojson = $this->toGeoJSON();
                return file_put_contents($path, $geojson);
            break;
            default:
                throw new \RuntimeException('Unsupported file format');
            break;
        }
    }

    /**
     * Array representation of GPX file.
     * @return array
     */
    public function toArray() : array
    {
        return SerializationHelper::filterEmpty([
            'metadata' => SerializationHelper::toArray($this->metadata),
            'wpt'      => SerializationHelper::toArray($this->wpt),
            'rte'      => SerializationHelper::toArray($this->rte),
            'trk'      => SerializationHelper::toArray($this->trk),
            'version'  => $this->version,
            'creator'  => $this->creator,
        ]);
    }

    /**
     * XML representation of GPX file.
     * @return \DOMDocument
     */
    public function toXML() : \DOMDocument
    {
        $doc = new \DOMDocument('1.0', 'UTF-8');
        $gpx = $doc->createElementNS('http://www.topografix.com/GPX/1/1', 'gpx');

        $gpx->setAttribute('version', $this->version);
        $gpx->setAttribute('creator', $this->creator ? $this->creator : GPXToolbox::SIGNATURE);

        if (!empty($this->metadata)) {
            $gpx->appendChild(MetadataParser::toXML($this->metadata, $doc));
        }
        
        if (!empty($this->wpt)) {
            foreach ($this->wpt as $wpt) {
                $gpx->appendChild(WaypointParser::toXML($wpt, $doc));
            }
        }

        if (!empty($this->rte)) {
            foreach ($this->rte as $rte) {
                $gpx->appendChild(RouteParser::toXML($rte, $doc));
            }
        }

        if (!empty($this->trk)) {
            foreach ($this->trk as $trk) {
                $gpx->appendChild(TrackParser::toXML($trk, $doc));
            }
        }

        $gpx->setAttributeNS(
            'http://www.w3.org/2001/XMLSchema-instance',
            'xsi:schemaLocation',
            'http://www.topografix.com/GPX/1/1 http://www.topografix.com/GPX/1/1/gpx.xsd'
        );
        
        $doc->appendChild($gpx);

        if (GPXToolbox::$PRETTY_PRINT) {
            $doc->formatOutput = true;
            $doc->preserveWhiteSpace = true;
        }

        return $doc;
    }

    /**
     * JSON encoded representation of GPX file.
     * @return string
     */
    public function toJSON() : string
    {
        return json_encode($this->toArray(), GPXToolbox::$PRETTY_PRINT ? JSON_PRETTY_PRINT : null);
    }

    /**
     * GeoJSON encoded representation of GPX file.
     * @return string
     */
    public function toGeoJSON()
    {
        $collection = GeoJSONHelper::createCollection($this);

        $geojson = json_encode($collection, GPXToolbox::$PRETTY_PRINT ? JSON_PRETTY_PRINT : null);

        return $geojson;
    }
}
