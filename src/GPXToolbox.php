<?php

namespace GPXToolbox;

use GPXToolbox\Models\Gpx;
use GPXToolbox\Serializers\XmlSerializer;

class GPXToolbox
{
    public const SIGNATURE = 'GPXToolbox';

    public static $configuration;

    public function __construct(?Configuration $configuration = null)
    {
        self::$configuration = $configuration ?? self::getConfiguration();
    }

    public function load(string $filename): Gpx
    {
        if (!file_exists($filename)) {
            throw new \RuntimeException(sprintf('File not found: %s', $filename));
        }

        $xml = file_get_contents($filename);

        if (!$xml) {
            throw new \RuntimeException(sprintf('Failed to read file: %s', $filename));
        }

        return $this->parse($xml);
    }

    public function parse(string $xml): Gpx
    {
        $doc = new \DOMDocument();

        $doc->loadXML($xml);

        $collection = XmlSerializer::deserialize($doc->documentElement);

        return new Gpx($collection);
    }

    public function save(Gpx $gpx, string $filename, string $format): int
    {
        $format = strtolower($format);

        switch ($format) {
            case 'gpx':
                $data = $gpx->toXml();
                break;
            case 'json':
                $data = $gpx->toJson();
                break;
            case 'geojson':
                $data = $gpx->toGeoJson();
                break;
            default:
                throw new \RuntimeException(sprintf('Unsupported file format: %s', $format));
        }

        $result = file_put_contents($filename, $data);

        if (!$result) {
            throw new \RuntimeException(sprintf('Failed to write file: %s', $filename));
        }

        return $result;
    }

    public static function getConfiguration(): Configuration
    {
        return self::$configuration ?? new Configuration();
    }
}
