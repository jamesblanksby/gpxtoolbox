<?php

namespace GPXToolbox;

use GPXToolbox\Models\GPX;
use GPXToolbox\Parsers\GPXParser;
use RuntimeException;

class GPXToolbox
{
    /**
     * The library signature.
     */
    public const SIGNATURE = 'GPXToolbox';

    /**
     * @var Configuration The configuration instance.
     */
    protected static $configuration;

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
     * @return GPX
     *
     * @throws RuntimeException If the file is not found or cannot be read.
     */
    public function load(string $filename)
    {
        if (!file_exists($filename)) {
            throw new RuntimeException(sprintf('File not found: %s', $filename));
        }

        $xml = file_get_contents($filename);

        if (!$xml) {
            throw new RuntimeException(sprintf('Failed to read file: %s', $filename));
        }

        return $this->parse($xml);
    }

    /**
     * Parse GPX data from an XML string.
     *
     * @param string $xml
     * @return GPX
     *
     * @throws RuntimeException If there is an issue loading or parsing the XML.
     */
    public function parse(string $xml)
    {
        libxml_use_internal_errors(true);
        $node = simplexml_load_string($xml);

        if (!$node) {
            $errors = libxml_get_errors();
            libxml_clear_errors();

            $errorMessages = array_map(function ($error) {
                return $error->message;
            }, $errors);

            throw new RuntimeException(sprintf('Failed to load or parse XML. Errors: %s', implode(', ', $errorMessages)));
        }

        return GPXParser::parse($node);
    }

    /**
     * Save a GPX object to a file in the specified format.
     *
     * @param string $filename
     * @param string $format
     * @param GPX $gpx
     * @return int
     *
     * @throws RuntimeException If there is an issue saving the GPX file.
     */
    public function save(string $filename, string $format, GPX $gpx): int
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
                throw new RuntimeException('Unsupported file format: %s', $format);
        }

        $result = file_put_contents($filename, $data);

        if (!$result) {
            throw new RuntimeException(sprintf('Failed to write file: %s', $filename));
        }

        return $result;
    }

    /**
     * Get the current configuration instance.
     *
     * @return Configuration
     */
    public static function getConfiguration()
    {
        return self::$configuration ?? new Configuration();
    }
}
