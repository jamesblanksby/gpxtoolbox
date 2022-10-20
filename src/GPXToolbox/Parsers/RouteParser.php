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

            $rte->name   = isset($node->name) ? (string) $node->name : null;
            $rte->cmt    = isset($node->cmt) ? (string) $node->cmt : null;
            $rte->desc   = isset($node->desc) ? (string) $node->desc : null;
            $rte->src    = isset($node->src) ? (string) $node->src : null;
            $rte->links  = isset($node->link) ? LinkParser::parse($node->link) : null;
            $rte->number = isset($node->number) ? (int) $node->number : null;
            $rte->type   = isset($node->type) ? (string) $node->type : null;

            if (isset($node->rtept)) {
                $rte->points = [];

                foreach ($node->rtept as $node) {
                    $rte->points []= PointParser::parse($node);
                }
            }

            $rte->extensions = isset($node->extensions) ? ExtensionParser::parse($node->extensions) : null;

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

        if (!empty($rte->name)) {
            $child = $doc->createElement('name', $rte->name);
            $node->appendChild($child);
        }

        if (!empty($rte->cmt)) {
            $child = $doc->createElement('cmt', $rte->cmt);
            $node->appendChild($child);
        }

        if (!empty($rte->desc)) {
            $child = $doc->createElement('desc', $rte->desc);
            $node->appendChild($child);
        }

        if (!empty($rte->src)) {
            $child = $doc->createElement('src', $rte->src);
            $node->appendChild($child);
        }

        if (!empty($rte->links)) {
            $children = LinkParser::toXMLArray($rte->links, $doc);
            foreach ($children as $child) {
                $node->appendChild($child);
            }
        }

        if (!empty($rte->number)) {
            $child = $doc->createElement('number', (string) $rte->number);
            $node->appendChild($child);
        }

        if (!empty($rte->type)) {
            $child = $doc->createElement('type', $rte->type);
            $node->appendChild($child);
        }

        if (!empty($rte->points)) {
            $children = PointParser::toXMLArray($rte->points, Point::ROUTEPOINT, $doc);
            foreach ($children as $child) {
                $node->appendChild($child);
            }
        }

        if (!empty($rte->extensions)) {
            $child = $doc->createElement('extension');
            $node->appendChild($child);
            foreach ($rte->extensions as $extension) {
                $child->appendChild(ExtensionParser::toXML($extension, $doc));
            }
        }

        return $node;
    }
}
