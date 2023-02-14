<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Types\GPX;
use SimpleXMLElement;

class GPXParser
{
    /**
     * Parses GPX data.
     * @param SimpleXMLElement $node
     * @return GPX
     */
    public static function parse(SimpleXMLElement $node): GPX
    {
        $gpx = new GPX();

        if (isset($node['version'])) {
            $gpx->version = (string) $node['version'];
        }
        if (isset($node['creator'])) {
            $gpx->creator = (string) $node['creator'];
        }
        if (isset($node->metadata)) {
            $gpx->metadata = MetadataParser::parse($node->metadata);
        }
        if (isset($node->wpt)) {
            $gpx->wpt = PointParser::parse($node->wpt);
        }
        if (isset($node->rte)) {
            $gpx->rte = RouteParser::parse($node->rte);
        }
        if (isset($node->trk)) {
            $gpx->trk = TrackParser::parse($node->trk);
        }
        if (isset($node->extensions)) {
            $gpx->extensions = ExtensionParser::parse($node->extensions);
        }

        return $gpx;
    }
}
