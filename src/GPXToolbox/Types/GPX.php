<?php

namespace GPXToolbox\Types;

use GPXToolbox\GPXToolbox;
use GPXToolbox\Helpers\GeoHelper;
use GPXToolbox\Helpers\GeoJSONHelper;
use GPXToolbox\Helpers\SerializationHelper;
use GPXToolbox\Helpers\StatsHelper;
use GPXToolbox\Models\Stats;
use GPXToolbox\Parsers\ExtensionParser;
use GPXToolbox\Parsers\MetadataParser;
use GPXToolbox\Parsers\RouteParser;
use GPXToolbox\Parsers\TrackParser;
use GPXToolbox\Parsers\WaypointParser;
use GPXToolbox\Types\Extensions\ExtensionInterface;

class GPX
{
    /**
     * Version of the file.
     * @var string
     */
    public $version = '1.1';

    /**
     * Creator of the file.
     * @var string
     */
    public $creator = 'GPXToolbox';

    /**
     * Metadata about the file.
     * @var Metadata|null
     */
    public $metadata = null;

    /**
     * A list of way points.
     * @var Point[];
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
     * A list of extensions.
     * @var ExtensionInterface[]
     */
    public $extensions = [];

    /**
     * Calculate GPX bounds.
     * @return array
     */
    public function bounds(): array
    {
        $points = $this->getPoints();
        $bounds = GeoHelper::getBounds($points);

        return $bounds;
    }

    /**
     * Calculate GPX stats.
     * @return Stats
     */
    public function stats(): Stats
    {
        $points = $this->getPoints();
        $stats = StatsHelper::calculateStats($points);

        return $stats;
    }

    /**
     * Simplify path by removing extra points with given tolerance.
     * @param float $tolerance
     * @param boolean $highestQuality
     * @return GPX
     */
    public function simplify(float $tolerance = 1.0, bool $highestQuality = false): GPX
    {
        if (empty($this->trk)) {
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
    public function save(string $path, string $format): bool
    {
        switch ($format) {
            case GPXToolbox::FORMAT_GPX:
                $doc = $this->toXML();
                $result = $doc->save($path);
                break;
            case GPXToolbox::FORMAT_JSON:
                $json = $this->toJSON();
                $result = file_put_contents($path, $json);
                break;
            case GPXToolbox::FORMAT_GEOJSON:
                $geojson = $this->toGeoJSON();
                $result = file_put_contents($path, $geojson);
                break;
            default:
                throw new \RuntimeException('Unsupported file format');
        }

        return $result;
    }

    /**
     * Array representation of GPX file.
     * @return array
     */
    public function toArray(): array
    {
        return SerializationHelper::filterEmpty([
            'version'    => $this->version,
            'creator'    => $this->creator,
            'metadata'   => SerializationHelper::toArray($this->metadata),
            'wpt'        => SerializationHelper::toArray($this->wpt),
            'rte'        => SerializationHelper::toArray($this->rte),
            'trk'        => SerializationHelper::toArray($this->trk),
            'extensions' => SerializationHelper::toArray($this->extensions),
        ]);
    }

    /**
     * XML representation of GPX file.
     * @return \DOMDocument
     */
    public function toXML(): \DOMDocument
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

        if (!empty($this->extensions)) {
            foreach ($this->extensions as $extension) {
                $gpx->appendChild(ExtensionParser::toXML($extension, $doc));
            }
        }

        $schemaLocationArray = [
            'http://www.topografix.com/GPX/1/1',
            'http://www.topografix.com/GPX/1/1/gpx.xsd',
        ];

        foreach (ExtensionParser::$PARSED_EXTENSIONS as $extension) {
            if (empty($extension::EXTENSION_PREFIX)) {
                continue;
            }

            $gpx->setAttributeNS(
                'http://www.w3.org/2000/xmlns/',
                sprintf('xmlns:%s', $extension::EXTENSION_PREFIX),
                $extension::EXTENSION_NAMESPACE
            );

            $schemaLocationArray[] = $extension::EXTENSION_NAMESPACE;
            $schemaLocationArray[] = $extension::EXTENSION_SCHEMA;
        }

        $gpx->setAttributeNS(
            'http://www.w3.org/2001/XMLSchema-instance',
            'xsi:schemaLocation',
            implode(' ', $schemaLocationArray)
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
    public function toJSON(): string
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
        $collection = $collection->toArray();

        $geojson = json_encode($collection, GPXToolbox::$PRETTY_PRINT ? JSON_PRETTY_PRINT : null);

        return $geojson;
    }

    /**
     * Recursively gather GPX points.
     * @return array
     */
    public function getPoints(): array
    {
        $points = [];

        if (empty($this->trk)) {
            return $points;
        }

        foreach ($this->trk as $trk) {
            $points = array_merge($points, $trk->getPoints());
        }

        return $points;
    }
}
