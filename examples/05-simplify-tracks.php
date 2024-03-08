<?php

use GPXToolbox\GPXToolbox;

include '../vendor/autoload.php';

$toolbox = new GPXToolbox();
$gpx = $toolbox->load('input.gpx');

foreach ($gpx->getTracks() as $track) {
    foreach ($track->getSegments() as $segment) {
        $simplifiedPoints = $segment->simplify(0.001)->getPoints();
        $segment->setPoints($simplifiedPoints);
    }
}

header('Content-Type: application/xml');
echo $gpx->toXml();
