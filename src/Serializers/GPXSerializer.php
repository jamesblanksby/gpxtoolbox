<?php

namespace GPXToolbox\Serializers;

use GPXToolbox\Abstracts\GPX\GPXTypeSerializer;
use GPXToolbox\Models\GPX;
use GPXToolbox\Serializers\GPX\MetadataSerializer;
use GPXToolbox\Serializers\GPX\RouteSerializer;
use GPXToolbox\Serializers\GPX\TrackSerializer;
use GPXToolbox\Serializers\GPX\WaypointSerializer;
use DateTimeImmutable;
use GPXToolbox\GPXToolbox;
use SimpleXMLElement;

final class GPXSerializer extends GPXTypeSerializer
{
    /**
     * Mapping of GPX file properties to their parsing configuration.
     *
     * @var array
     */
    protected static $map = [
        'version' => [
            'type' => 'attribute',
        ],
        'creator' => [
            'type' => 'attribute',
        ],
        'metadata' => [
            'type' => 'node',
            'callable' => [MetadataSerializer::class, 'serialize',],
        ],
        'wpt' => [
            'type' => 'node',
            'callable' => [WaypointSerializer::class, 'serialize',],
        ],
        'rte' => [
            'type' => 'node',
            'callable' => [RouteSerializer::class, 'serialize',],
        ],
        'trk' => [
            'type' => 'node',
            'callable' => [TrackSerializer::class, 'serialize',],
        ],
    ];

    /**
     * Serialize GPX data from a SimpleXMLElement.
     *
     * @param SimpleXMLElement $node
     * @return GPX
     */
    public static function serialize(SimpleXMLElement $node): GPX
    {
        $properties = parent::propertiesFromXML($node, self::$map);

        return new GPX($properties);
    }

    /**
     * Serialize a coordinate value from a string.
     *
     * @param string $value
     * @return float
     */
    public static function serializeCoordinate(string $value): float
    {
        return round((float) $value, GPXToolbox::getConfiguration()->getCoordinatePrecision());
    }

    /**
     * Serialize a string representation of a date and time.
     *
     * @param string $value
     * @return DateTimeImmutable
     */
    public static function serializeDateTime(string $value): DateTimeImmutable
    {
        return new DateTimeImmutable($value);
    }

    /**
     * Serialize an elevation value from a string.
     *
     * @param string $value
     * @return float
     */
    public static function serializeElevation(string $value): float
    {
        return round((float) $value, GPXToolbox::getConfiguration()->getElevationPrecision());
    }
}
