<?php

use GPXToolbox\GPXToolbox;

include '../vendor/autoload.php';

$toolbox = new GPXToolbox();
$gpx = $toolbox->load('input.gpx');

$toolbox->save($gpx, 'output.json', 'json', JSON_PRETTY_PRINT);
