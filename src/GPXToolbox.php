<?php

namespace GPXToolbox;

use GPXToolbox\Models\Gpx;
use GPXToolbox\Serializers\XmlSerializer;

class GPXToolbox
{
    /**
     * GPXToolbox signature.
     */
    public const SIGNATURE = 'GPXToolbox';

    /**
     * Configuration instance.
     *
     * @var Configuration|null
     */
    public static ?Configuration $configuration = null;

    /**
     * GPXToolbox constructor.
     *
     * @param Configuration|null $configuration
     */
    public function __construct(?Configuration $configuration = null)
    {
        self::$configuration = $configuration ?? self::getConfiguration();
    }

    /**
     * Load GPX data from a file.
     *
     * @param string $filename
     * @throws \RuntimeException If the file is not found or cannot be read.
     */
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

    /**
     * Parse GPX data from XML.
     *
     * @param string $xml
     */
    public function parse(string $xml): Gpx
    {
        $doc = new \DOMDocument();

        $doc->loadXML($xml);

        $collection = XmlSerializer::deserialize($doc->documentElement);

        return new Gpx($collection);
    }

    /**
     * Save GPX data to a file in specified format.
     *
     * @param Gpx $gpx
     * @param string $filename
     * @param string $format
     * @throws \RuntimeException If an unsupported format or write failure occurs.
     */
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

    /**
     * Get the configuration object.
     *
     * @return Configuration
     */
    public static function getConfiguration(): Configuration
    {
        return self::$configuration ?? new Configuration();
    }
}
