<?php

use GPXToolbox\GPXToolbox;

include '../vendor/autoload.php';

$toolbox = new GPXToolbox();
$gpx = $toolbox->load('input.gpx');

$statistics = $gpx->getTracks()->getStatistics();

echo sprintf('<pre>%s</pre>', print_r($statistics->toArray(), true));
