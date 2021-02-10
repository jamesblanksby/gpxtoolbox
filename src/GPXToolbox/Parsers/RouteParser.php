<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Types\Route;

class RouteParser
{
    /**
     * Parses route data.
     * @param \SimpleXMLElement[] $nodes
     * @return Route[]
     */
    public static function parse($nodes) : array
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

            $routes []= $rte;
        }
        

        return $routes;
    }

    /**
     * XML representation of route data.
     * @param Point $rte
     * @param \DOMDocument $doc
     * @return \DOMNode
     */
    public static function toXML(Point $rte, \DOMDocument $doc) : \DOMNode
    {
        $node = PointParser::toXML($rte, Point::WAYPOINT, $doc);

        return $node;
    }
}
