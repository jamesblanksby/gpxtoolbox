<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Types\Point;
use GPXToolbox\Helpers\DateTimeHelper;
use GPXToolbox\GPXToolbox;

class PointParser
{
    /**
     * Parses point data.
     * @param \SimpleXMLElement $node
     * @return Point
     */
    public static function parse(\SimpleXMLElement $node): Point
    {
        $point = new Point();

        $point->lat           = isset($node['lat']) ? round((float) $node['lat'], GPXToolbox::$COORDINATE_PRECISION) : null;
        $point->lon           = isset($node['lon']) ? round((float) $node['lon'], GPXToolbox::$COORDINATE_PRECISION) : null;
        $point->ele           = isset($node->ele) ? round((float) $node->ele, GPXToolbox::$ELEVATION_PRECISION) : null;
        $point->time          = isset($node->time) ? DateTimeParser::parse($node->time) : null;
        $point->magvar        = isset($node->magvar) ? (float) $node->magvar : null;
        $point->geoidheight   = isset($node->geoidheight) ? (float) $node->geoidheight : null;
        $point->name          = isset($node->name) ? (string) $node->name : null;
        $point->cmt           = isset($node->cmt) ? (string) $node->cmt : null;
        $point->desc          = isset($node->desc) ? (string) $node->desc : null;
        $point->src           = isset($node->src) ? (string) $node->src : null;
        $point->links         = isset($node->links) ? LinkParser::parse($node->link) : null;
        $point->sym           = isset($node->sym) ? (string) $node->sym : null;
        $point->fix           = isset($node->fix) ? (string) $node->fix : null;
        $point->sat           = isset($node->sat) ? (int) $node->sat : null;
        $point->hdop          = isset($node->hdop) ? (float) $node->hdop : null;
        $point->vdop          = isset($node->vdop) ? (float) $node->vdop : null;
        $point->pdop          = isset($node->pdop) ? (float) $node->pdop : null;
        $point->ageofdgpsdata = isset($node->ageofdgpsdata) ? (float) $node->ageofdgpsdata : null;
        $point->dgpsid        = isset($node->dgpsid) ? (int) $node->dgpsid : null;
        $point->extensions    = isset($node->extensions) ? ExtensionParser::parse($node->extensions) : null;

        return $point;
    }

    /**
     * XML representation of point data.
     * @param Point $point
     * @param string $name
     * @param \DOMDocument $doc
     * @return \DOMNode
     */
    public static function toXML(Point $point, string $name, \DOMDocument $doc): \DOMNode
    {
        $node = $doc->createElement($name);

        if (!empty($point->lat)) {
            $node->setAttribute('lat', (string) $point->lat);
        }

        if (!empty($point->lon)) {
            $node->setAttribute('lon', (string) $point->lon);
        }

        if (!empty($point->ele)) {
            $child = $doc->createElement('ele', (string) $point->ele);
            $node->appendChild($child);
        }

        if (!empty($point->time)) {
            $child = $doc->createElement('time', DateTimeHelper::format($point->time));
            $node->appendChild($child);
        }

        if (!empty($point->magvar)) {
            $child = $doc->createElement('magvar', (string) $point->magvar);
            $node->appendChild($child);
        }

        if (!empty($point->geoidheight)) {
            $child = $doc->createElement('geoidheight', (string) $point->geoidheight);
            $node->appendChild($child);
        }

        if (!empty($point->name)) {
            $child = $doc->createElement('name', $point->name);
            $node->appendChild($child);
        }

        if (!empty($point->cmt)) {
            $child = $doc->createElement('cmt', $point->cmt);
            $node->appendChild($child);
        }

        if (!empty($point->desc)) {
            $child = $doc->createElement('desc', $point->desc);
            $node->appendChild($child);
        }

        if (!empty($point->src)) {
            $child = $doc->createElement('src', $point->src);
            $node->appendChild($child);
        }

        if (!empty($point->links)) {
            $children = LinkParser::toXMLArray($point->links, $doc);
            foreach ($children as $child) {
                $node->appendChild($child);
            }
        }

        if (!empty($point->sym)) {
            $child = $doc->createElement('sym', $point->sym);
            $node->appendChild($child);
        }

        if (!empty($point->fix)) {
            $child = $doc->createElement('fix', $point->fix);
            $node->appendChild($child);
        }

        if (!empty($point->sat)) {
            $child = $doc->createElement('sat', (string) $point->sat);
            $node->appendChild($child);
        }

        if (!empty($point->hdop)) {
            $child = $doc->createElement('hdop', (string) $point->hdop);
            $node->appendChild($child);
        }

        if (!empty($point->vdop)) {
            $child = $doc->createElement('vdop', (string) $point->vdop);
            $node->appendChild($child);
        }

        if (!empty($point->pdop)) {
            $child = $doc->createElement('pdop', (string) $point->pdop);
            $node->appendChild($child);
        }

        if (!empty($point->ageofdgpsdata)) {
            $child = $doc->createElement('ageofdgpsdata', (string) $point->ageofdgpsdata);
            $node->appendChild($child);
        }

        if (!empty($point->dgpsid)) {
            $child = $doc->createElement('dgpsid', (string) $point->dgpsid);
            $node->appendChild($child);
        }

        if (!empty($point->extensions)) {
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
     * @param string $key
     * @param \DOMDocument $doc
     * @return \DOMNode[]
     */
    public static function toXMLArray(array $points, string $key, \DOMDocument $doc): array
    {
        $result = [];

        foreach ($points as $point) {
            $result []= self::toXML($point, $key, $doc);
        }

        return $result;
    }
}
