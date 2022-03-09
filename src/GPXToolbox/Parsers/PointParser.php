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
    public static function parse(\SimpleXMLElement $node) : Point
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

        return $point;
    }

    /**
     * XML representation of point data.
     * @param Point $point
     * @param string $key
     * @param \DOMDocument $doc
     * @return \DOMNode
     */
    public static function toXML(Point $point, string $key, \DOMDocument $doc) : \DOMNode
    {
        $node = $doc->createElement($key);

        if (!empty($point->lat)) {
            $node->setAttribute('lat', $point->lat);
        }

        if (!empty($point->lon)) {
            $node->setAttribute('lon', $point->lon);
        }

        if (!empty($point->ele)) {
            $child = $doc->createElement('ele', $point->ele);
            $node->appendChild($child);
        }

        if (!empty($point->time)) {
            $child = $doc->createElement('time', DateTimeHelper::format($point->time));
            $node->appendChild($child);
        }

        if (!empty($point->magvar)) {
            $child = $doc->createElement('magvar', $point->magvar);
            $node->appendChild($child);
        }

        if (!empty($point->geoidheight)) {
            $child = $doc->createElement('geoidheight', $point->geoidheight);
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
            $child = $doc->createElement('sat', $point->sat);
            $node->appendChild($child);
        }

        if (!empty($point->hdop)) {
            $child = $doc->createElement('hdop', $point->hdop);
            $node->appendChild($child);
        }

        if (!empty($point->vdop)) {
            $child = $doc->createElement('vdop', $point->vdop);
            $node->appendChild($child);
        }

        if (!empty($point->pdop)) {
            $child = $doc->createElement('pdop', $point->pdop);
            $node->appendChild($child);
        }

        if (!empty($point->ageofdgpsdata)) {
            $child = $doc->createElement('ageofdgpsdata', $point->ageofdgpsdata);
            $node->appendChild($child);
        }

        if (!empty($point->dgpsid)) {
            $child = $doc->createElement('dgpsid', $point->dgpsid);
            $node->appendChild($child);
        }

        return $node;
    }
}
