<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Types\Point;
use GPXToolbox\Types\Route;
use DOMDocument;
use DOMNode;
use SimpleXMLElement;

class RouteParser
{
    /**
     * Parses route data.
     * @param SimpleXMLElement $nodes
     * @return Route[]
     */
    public static function parse($nodes): array
    {
        $routes = [];

        foreach ($nodes as $node) {
            $rte = new Route();

            if (isset($node->name)) {
                $rte->name = (string) $node->name;
            }
            if (isset($node->cmt)) {
                $rte->cmt = (string) $node->cmt;
            }
            if (isset($node->desc)) {
                $rte->desc = (string) $node->desc;
            }
            if (isset($node->src)) {
                $rte->src = (string) $node->src;
            }
            if (isset($node->link)) {
                $rte->links = LinkParser::parse($node->link);
            }
            if (isset($node->number)) {
                $rte->number = (int) $node->number;
            }
            if (isset($node->type)) {
                $rte->type = (string) $node->type;
            }
            if (isset($node->rtept)) {
                $rte->points = PointParser::parse($node->rtept);
            }
            if (isset($node->extensions)) {
                $rte->extensions = ExtensionParser::parse($node->extensions);
            }

            $routes []= $rte;
        }


        return $routes;
    }

    /**
     * XML representation of route data.
     * @param Route $rte
     * @param DOMDocument $doc
     * @return DOMNode
     */
    public static function toXML(Route $rte, DOMDocument $doc): DOMNode
    {
        $node = $doc->createElement('rte');

        if ($rte->name) {
            $child = $doc->createElement('name', $rte->name);
            $node->appendChild($child);
        }

        if ($rte->cmt) {
            $child = $doc->createElement('cmt', $rte->cmt);
            $node->appendChild($child);
        }

        if ($rte->desc) {
            $child = $doc->createElement('desc', $rte->desc);
            $node->appendChild($child);
        }

        if ($rte->src) {
            $child = $doc->createElement('src', $rte->src);
            $node->appendChild($child);
        }

        if ($rte->links) {
            $children = LinkParser::toXMLArray($rte->links, $doc);
            foreach ($children as $child) {
                $node->appendChild($child);
            }
        }

        if ($rte->number) {
            $child = $doc->createElement('number', (string) $rte->number);
            $node->appendChild($child);
        }

        if ($rte->type) {
            $child = $doc->createElement('type', $rte->type);
            $node->appendChild($child);
        }

        if ($rte->points) {
            $children = PointParser::toXMLArray($rte->points, Point::WAYPOINT, $doc);
            foreach ($children as $child) {
                $node->appendChild($child);
            }
        }

        if ($rte->extensions) {
            $child = $doc->createElement('extension');
            $node->appendChild($child);
            foreach ($rte->extensions as $extension) {
                $child->appendChild(ExtensionParser::toXML($extension, $doc));
            }
        }

        return $node;
    }
}
