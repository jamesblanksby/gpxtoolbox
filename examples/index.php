<?php

use GPXToolbox\GPXToolbox;

include '../vendor/autoload.php';

$toolbox = new GPXToolbox();
$gpx = $toolbox::load(__DIR__ . '/untitled.gpx');

// header('Content-Type: application/xml; charset=utf-8');
$doc = $gpx->toXML();
die($doc->saveHTML());

foreach ($gpx->trk as $trk) {
    echo sprintf('<pre>%s</pre>', print_r($trk->extensions, true));
}
