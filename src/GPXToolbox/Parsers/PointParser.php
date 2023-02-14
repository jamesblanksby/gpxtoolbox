<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\GPXToolbox;
use GPXToolbox\Helpers\DateTimeHelper;
use GPXToolbox\Types\Point;
use DOMDocument;
use DOMNode;
use SimpleXMLElement;

class PointParser
{
    /**
     * Parses point data.
     * @param SimpleXMLElement $nodes
     * @return Point[]
     */
    public static function parse($nodes): array
    {
        $points = [];

        foreach ($nodes as $node) {
            $point = new Point();

            if (isset($node['lat'])) {
                $point->lat = round((float) $node['lat'], GPXToolbox::$COORDINATE_PRECISION);
            }
            if (isset($node['lon'])) {
                $point->lon = round((float) $node['lon'], GPXToolbox::$COORDINATE_PRECISION);
            }
            if (isset($node->ele)) {
                $point->ele = round((float) $node->ele, GPXToolbox::$ELEVATION_PRECISION);
            }
            if (isset($node->time)) {
                $point->time = DateTimeParser::parse($node->time);
            }
            if (isset($node->magvar)) {
                $point->magvar = (float) $node->magvar;
            }
            if (isset($node->geoidheight)) {
                $point->geoidheight = (float) $node->geoidheight;
            }
            if (isset($node->name)) {
                $point->name = (string) $node->name;
            }
            if (isset($node->cmt)) {
                $point->cmt = (string) $node->cmt;
            }
            if (isset($node->desc)) {
                $point->desc = (string) $node->desc;
            }
            if (isset($node->src)) {
                $point->src = (string) $node->src;
            }
            if (isset($node->links)) {
                $point->links = LinkParser::parse($node->link);
            }
            if (isset($node->sym)) {
                $point->sym = (string) $node->sym;
            }
            if (isset($node->fix)) {
                $point->fix = (string) $node->fix;
            }
            if (isset($node->sat)) {
                $point->sat = (int) $node->sat;
            }
            if (isset($node->hdop)) {
                $point->hdop = (float) $node->hdop;
            }
            if (isset($node->vdop)) {
                $point->vdop = (float) $node->vdop;
            }
            if (isset($node->pdop)) {
                $point->pdop = (float) $node->pdop;
            }
            if (isset($node->ageofdgpsdata)) {
                $point->ageofdgpsdata = (float) $node->ageofdgpsdata;
            }
            if (isset($node->dgpsid)) {
                $point->dgpsid = (int) $node->dgpsid;
            }
            if (isset($node->extensions)) {
                $point->extensions = ExtensionParser::parse($node->extensions);
            }

            $points []= $point;
        }

        return $points;
    }

    /**
     * XML representation of point data.
     * @param Point $point
     * @param string $key
     * @param DOMDocument $doc
     * @return DOMNode
     */
    public static function toXML(Point $point, string $key, DOMDocument $doc): DOMNode
    {
        $node = $doc->createElement($key);

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
     * @param DOMDocument $doc
     * @return DOMNode[]
     */
    public static function toXMLArray(array $points, string $key, DOMDocument $doc): array
    {
        $result = [];

        foreach ($points as $point) {
            $result []= self::toXML($point, $key, $doc);
        }

        return $result;
    }
}
