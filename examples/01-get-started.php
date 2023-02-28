<?php

use GPXToolbox\GPXToolbox;

include '../vendor/autoload.php';

$toolbox = new GPXToolbox();
$gpx = $toolbox::load(__DIR__ . '/input.gpx');

echo sprintf('<pre>%s</pre>', print_r($gpx->toArray(), true));
