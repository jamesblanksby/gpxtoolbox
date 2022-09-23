<?php

use GPXToolbox\GPXToolbox;
use GPXToolbox\Types\Segment;
use GPXToolbox\Types\Track;

include '../vendor/autoload.php';

$toolbox = new GPXToolbox();
$gpx = $toolbox::load('input.gpx');

$trk = new Track();
$trkseg = new Segment();
array_push($trkseg->points, ...$gpx->getPoints());
$trk->trkseg = [$trkseg,];
$gpx->trk = [$trk,];

header('Content-Type: application/xml');
echo $gpx->toXML()->saveXML();
