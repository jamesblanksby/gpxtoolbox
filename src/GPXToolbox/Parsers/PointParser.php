<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Helpers\DateTimeHelper;
use GPXToolbox\Parsers\Values\CoordinateParser;
use GPXToolbox\Parsers\Values\DateTimeParser;
use GPXToolbox\Parsers\Values\ElevationParser;
use GPXToolbox\Types\Point;
use DOMDocument;
use DOMNode;
use SimpleXMLElement;

class PointParser
{
    /**
     * @var array<mixed>
     */
    private static $map = [
        'lat' => [
            'name' => 'lat',
            'type' => 'attribute',
            'parser' => CoordinateParser::class,
        ],
        'lon' => [
            'name' => 'lon',
            'type' => 'attribute',
            'parser' => CoordinateParser::class,
        ],
        'ele' => [
            'name' => 'ele',
            'type' => 'element',
            'parser' => ElevationParser::class,
        ],
        'time' => [
            'name' => 'time',
            'type' => 'element',
            'parser' => DateTimeParser::class,
        ],
        'magvar' => [
            'name' => 'magvar',
            'type' => 'element',
            'parser' => 'float',
        ],
        'name' => [
            'name' => 'name',
            'type' => 'element',
            'parser' => 'string',
        ],
        'cmt' => [
            'name' => 'cmt',
            'type' => 'element',
            'parser' => 'string',
        ],
        'desc' => [
            'name' => 'desc',
            'type' => 'element',
            'parser' => 'string',
        ],
        'src' => [
            'name' => 'src',
            'type' => 'element',
            'parser' => 'string',
        ],
        'link' => [
            'name' => 'links',
            'type' => 'element',
            'parser' => LinkParser::class,
        ],
        'sym' => [
            'name' => 'sym',
            'type' => 'element',
            'parser' => 'string',
        ],
        'fix' => [
            'name' => 'fix',
            'type' => 'element',
            'parser' => 'string',
        ],
        'sat' => [
            'name' => 'sat',
            'type' => 'element',
            'parser' => 'integer',
        ],
        'hdop' => [
            'name' => 'hdop',
            'type' => 'element',
            'parser' => 'float',
        ],
        'vdop' => [
            'name' => 'vdop',
            'type' => 'element',
            'parser' => 'float',
        ],
        'pdop' => [
            'name' => 'pdop',
            'type' => 'element',
            'parser' => 'float',
        ],
        'ageofgpsdata' => [
            'name' => 'ageofgpsdata',
            'type' => 'element',
            'parser' => 'float',
        ],
        'dgpsid' => [
            'name' => 'dgpsid',
            'type' => 'element',
            'parser' => 'integer',
        ],
        'extensions' => [
            'name' => 'extensions',
            'type' => 'element',
            'parser' => ExtensionParser::class,
        ],
    ];

    /**
     * Parses point data.
     * @param SimpleXMLElement $nodes
     * @return Point[]
     */
    public static function parse($nodes): array
    {
        $points = [];

        foreach ($nodes as $node) {
            $points []= XMLElementParser::parse($node, new Point($node->getName()), self::$map);
        }

        return $points;
    }

    /**
     * XML representation of point data.
     * @param Point $point
     * @param DOMDocument $doc
     * @return DOMNode
     */
    public static function toXML(Point $point, DOMDocument $doc): DOMNode
    {
        $node = $doc->createElement($point->key);

        if ($point->lat) {
            $node->setAttribute('lat', (string) $point->lat);
        }

        if ($point->lon) {
            $node->setAttribute('lon', (string) $point->lon);
        }

        if ($point->ele) {
            $child = $doc->createElement('ele', (string) $point->ele);
            $node->appendChild($child);
        }

        if ($point->time) {
            $time = DateTimeHelper::format($point->time);
            if (!is_null($time)) {
                $child = $doc->createElement('time', $time);
                $node->appendChild($child);
            }
        }

        if ($point->magvar) {
            $child = $doc->createElement('magvar', (string) $point->magvar);
            $node->appendChild($child);
        }

        if ($point->geoidheight) {
            $child = $doc->createElement('geoidheight', (string) $point->geoidheight);
            $node->appendChild($child);
        }

        if ($point->name) {
            $child = $doc->createElement('name', $point->name);
            $node->appendChild($child);
        }

        if ($point->cmt) {
            $child = $doc->createElement('cmt', $point->cmt);
            $node->appendChild($child);
        }

        if ($point->desc) {
            $child = $doc->createElement('desc', $point->desc);
            $node->appendChild($child);
        }

        if ($point->src) {
            $child = $doc->createElement('src', $point->src);
            $node->appendChild($child);
        }

        if ($point->links) {
            $children = LinkParser::toXMLArray($point->links, $doc);
            foreach ($children as $child) {
                $node->appendChild($child);
            }
        }

        if ($point->sym) {
            $child = $doc->createElement('sym', $point->sym);
            $node->appendChild($child);
        }

        if ($point->fix) {
            $child = $doc->createElement('fix', $point->fix);
            $node->appendChild($child);
        }

        if ($point->sat) {
            $child = $doc->createElement('sat', (string) $point->sat);
            $node->appendChild($child);
        }

        if ($point->hdop) {
            $child = $doc->createElement('hdop', (string) $point->hdop);
            $node->appendChild($child);
        }

        if ($point->vdop) {
            $child = $doc->createElement('vdop', (string) $point->vdop);
            $node->appendChild($child);
        }

        if ($point->pdop) {
            $child = $doc->createElement('pdop', (string) $point->pdop);
            $node->appendChild($child);
        }

        if ($point->ageofdgpsdata) {
            $child = $doc->createElement('ageofdgpsdata', (string) $point->ageofdgpsdata);
            $node->appendChild($child);
        }

        if ($point->dgpsid) {
            $child = $doc->createElement('dgpsid', (string) $point->dgpsid);
            $node->appendChild($child);
        }

        if ($point->extensions) {
            $child = $doc->createElement('extension');
            $node->appendChild($child);
            foreach ($point->extensions as $extension) {
                $child->appendChild(ExtensionParser::toXML($extension, $doc));
            }
        }

        return $node;
    }

    /**
     * XML representation of array point data.
     * @param Point[] $points
     * @param DOMDocument $doc
     * @return DOMNode[]
     */
    public static function toXMLArray(array $points, DOMDocument $doc): array
    {
        $result = [];

        foreach ($points as $point) {
            $result []= self::toXML($point, $doc);
        }

        return $result;
    }
}
