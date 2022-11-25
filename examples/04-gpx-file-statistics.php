<?php

use GPXToolbox\GPXToolbox;

include '../vendor/autoload.php';

$toolbox = new GPXToolbox();
$gpx = $toolbox::load('input.gpx');

$stats = $gpx->getStats();

echo sprintf('<pre>%s</pre>', print_r($stats, true));
