<?php

namespace GPXToolbox\Serializers\GPX;

use GPXToolbox\Abstracts\GPX\GPXTypeSerializer;
use GPXToolbox\Models\GPX\Segment;
use GPXToolbox\Models\GPX\SegmentCollection;
use SimpleXMLElement;

final class SegmentSerializer extends GPXTypeSerializer
{
    /**
     * Mapping of segment properties to their parsing configuration.
     *
     * @var array
     */
    protected static $map = [
        'trkpt' => [
            'type' => 'node',
            'callable' => [PointSerializer::class, 'serialize',],
        ],
    ];

    /**
     * Serialize segment from a SimpleXMLElement.
     *
     * @param SimpleXMLElement $nodes
     * @return SegmentCollection
     */
    public static function serialize(SimpleXMLElement $nodes): SegmentCollection
    {
        $segments = new SegmentCollection();

        foreach ($nodes as $node) {
            $properties = parent::propertiesFromXML($node, self::$map);

            $segments->add(new Segment($properties));
        }

        return $segments;
    }
}
