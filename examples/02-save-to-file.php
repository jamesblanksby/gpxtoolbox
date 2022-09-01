<?php

use GPXToolbox\GPXToolbox;

include '../vendor/autoload.php';

$toolbox = new GPXToolbox();
$gpx = $toolbox::load('input.gpx');

$gpx->save('output.gpx', GPXToolbox::FORMAT_GPX);
$gpx->save('output.json', GPXToolbox::FORMAT_JSON);
$gpx->save('output.geojson', GPXToolbox::FORMAT_GEOJSON);
