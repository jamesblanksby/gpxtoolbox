<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Types\Route;
use DOMDocument;
use DOMNode;
use SimpleXMLElement;

class RouteParser
{
    /**
     * @var array<mixed>
     */
    private static $map = [
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
        'number' => [
            'name' => 'number',
            'type' => 'element',
            'parser' => 'integer',
        ],
        'type' => [
            'name' => 'type',
            'type' => 'element',
            'parser' => 'string',
        ],
        'rtept' => [
            'name' => 'points',
            'type' => 'element',
            'parser' => PointParser::class,
        ],
        'extensions' => [
            'name' => 'extensions',
            'type' => 'element',
            'parser' => ExtensionParser::class,
        ],
    ];

    /**
     * Parses route data.
     * @param SimpleXMLElement $nodes
     * @return array<int, Route>
     */
    public static function parse($nodes): array
    {
        $routes = [];

        foreach ($nodes as $node) {
            $routes []= XMLElementParser::parse($node, new Route(), self::$map);
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
            $children = PointParser::toXMLArray($rte->points, $doc);
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
