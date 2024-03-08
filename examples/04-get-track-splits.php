<?php

use GPXToolbox\GPXToolbox;

include '../vendor/autoload.php';

$toolbox = new GPXToolbox();
$gpx = $toolbox->load('input.gpx');

$splits = $gpx->getTracks()->getSplits();

echo sprintf('<pre>%s</pre>', print_r($splits->toArray(), true));
