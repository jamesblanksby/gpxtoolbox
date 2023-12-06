<?php

namespace GPXToolbox\Serializers\GPX;

use GPXToolbox\Abstracts\GPX\GPXTypeSerializer;
use GPXToolbox\Models\GPX\Track;
use GPXToolbox\Models\GPX\TrackCollection;
use SimpleXMLElement;

final class TrackSerializer extends GPXTypeSerializer
{
    /**
     * Mapping of track properties to their parsing configuration.
     *
     * @var array
     */
    protected static $map = [
        'name' => [
            'type' => 'node',
        ],
        'cmt' => [
            'type' => 'node',
        ],
        'desc' => [
            'type' => 'node',
        ],
        'src' => [
            'type' => 'node',
        ],
        'link' => [
            'type' => 'node',
            'callable' => [LinkSerializer::class, 'serialize',],
        ],
        'number' => [
            'type' => 'node',
            'cast' => 'int',
        ],
        'type' => [
            'type' => 'node',
        ],
        'trkseg' => [
            'type' => 'node',
            'callable' => [SegmentSerializer::class, 'serialize',],
        ],
    ];

    /**
     * Serialize track from a SimpleXMLElement.
     *
     * @param SimpleXMLElement $nodes
     * @return TrackCollection
     */
    public static function serialize(SimpleXMLElement $nodes): TrackCollection
    {
        $tracks = new TrackCollection();

        foreach ($nodes as $node) {
            $properties = parent::propertiesFromXML($node, self::$map);

            $tracks->add(new Track($properties));
        }

        return $tracks;
    }
}
