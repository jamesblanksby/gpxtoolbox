<?php

namespace GPXToolbox\Types;

use GPXToolbox\GPXToolbox;
use GPXToolbox\Helpers\GeoHelper;
use GPXToolbox\Helpers\GeoJSONHelper;
use GPXToolbox\Helpers\SerializationHelper;
use GPXToolbox\Helpers\StatsHelper;
use GPXToolbox\Interfaces\ArraySerializableInterface;
use GPXToolbox\Models\Stats;
use GPXToolbox\Parsers\ExtensionParser;
use GPXToolbox\Parsers\MetadataParser;
use GPXToolbox\Parsers\PointParser;
use GPXToolbox\Parsers\RouteParser;
use GPXToolbox\Parsers\TrackParser;
use GPXToolbox\Types\Extensions\ExtensionAbstract;
use DOMDocument;
use RuntimeException;

class GPX implements ArraySerializableInterface
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
     * @var ExtensionAbstract[]
     */
    public $extensions = [];

    /**
     * Add waypoint to gpx.
     * @param Point $wpt
     * @return self
    */
    public function addWaypoint(Point $wpt): self
    {
        array_push($this->wpt, $wpt);

        return $this;
    }

    /**
     * Add route to gpx.
     * @param Route $rte
     * @return self
    */
    public function addRoute(Route $rte): self
    {
        array_push($this->rte, $rte);

        return $this;
    }

    /**
     * Add track to gpx.
     * @param Track $trk
     * @return self
    */
    public function addTrack(Track $trk): self
    {
        array_push($this->trk, $trk);

        return $this;
    }

    /**
     * Add extension to gpx.
     * @param ExtensionAbstract $extension
     * @return self
    */
    public function addExtension(ExtensionAbstract $extension): self
    {
        array_push($this->extensions, $extension);

        return $this;
    }

    /**
     * Recursively gather GPX points.
     * @return Point[]
     */
    public function getPoints(): array
    {
        $points = [];

        if (!$this->trk) {
            return $points;
        }

        foreach ($this->trk as $trk) {
            $points = array_merge($points, $trk->getPoints());
        }

        return $points;
    }

    /**
     * Calculate GPX bounds.
     * @return mixed[]
     */
    public function getBounds(): array
    {
        $points = $this->getPoints();
        $bounds = GeoHelper::getBounds($points);

        return $bounds;
    }

    /**
     * Calculate GPX stats.
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
     * @return GPX
     */
    public function simplify(float $tolerance = 1.0, bool $highestQuality = false): GPX
    {
        if (!$this->trk) {
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
     * @return integer|boolean
     * @throws RuntimeException
     */
    public function save(string $path, string $format): int|bool
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
                throw new RuntimeException('Unsupported file format');
        }

        return $result;
    }

    /**
     * XML representation of GPX file.
     * @return DOMDocument
     */
    public function toXML(): DOMDocument
    {
        $doc = new DOMDocument('1.0', 'utf-8');
        $gpx = $doc->createElementNS('http://www.topografix.com/GPX/1/1', 'gpx');

        $gpx->setAttribute('version', $this->version);
        $gpx->setAttribute('creator', $this->creator ? $this->creator : GPXToolbox::SIGNATURE);

        if ($this->metadata) {
            $gpx->appendChild(MetadataParser::toXML($this->metadata, $doc));
        }

        if ($this->wpt) {
            foreach ($this->wpt as $wpt) {
                $gpx->appendChild(PointParser::toXML($wpt, Point::WAYPOINT, $doc));
            }
        }

        if ($this->rte) {
            foreach ($this->rte as $rte) {
                $gpx->appendChild(RouteParser::toXML($rte, $doc));
            }
        }

        if ($this->trk) {
            foreach ($this->trk as $trk) {
                $gpx->appendChild(TrackParser::toXML($trk, $doc));
            }
        }

        if ($this->extensions) {
            $children = ExtensionParser::toXMLArray($this->extensions, $doc);
            foreach ($children as $child) {
                $gpx->appendChild($child);
            }
        }

        $schemaLocationArray = [
            'http://www.topografix.com/GPX/1/1',
            'http://www.topografix.com/GPX/1/1/gpx.xsd',
        ];

        foreach (ExtensionParser::$PARSED_EXTENSIONS as $extension) {
            if (!$extension::$EXTENSION_PREFIX) {
                continue;
            }

            $gpx->setAttributeNS(
                'http://www.w3.org/2000/xmlns/',
                sprintf('xmlns:%s', $extension::$EXTENSION_PREFIX),
                $extension::$EXTENSION_NAMESPACE
            );

            $schemaLocationArray []= $extension::$EXTENSION_NAMESPACE;
            $schemaLocationArray []= $extension::$EXTENSION_SCHEMA;
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
     * GeoJSON encoded representation of GPX file.
     * @return string
     */
    public function toGeoJSON(): string
    {
        $collection = GeoJSONHelper::createCollection($this);
        $collection = $collection->toArray();

        $geojson = json_encode($collection, GPXToolbox::$PRETTY_PRINT ? JSON_PRETTY_PRINT : 0) ?: '';

        return $geojson;
    }

    /**
     * JSON encoded representation of GPX file.
     * @return string
     */
    public function toJSON(): string
    {
        $json = json_encode($this->toArray(), GPXToolbox::$PRETTY_PRINT ? JSON_PRETTY_PRINT : 0) ?: '';

        return $json;
    }

    /**
     * Array representation of GPX file.
     * @return mixed[]
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
}
