<?php

use GPXToolbox\GPXToolbox;

include '../vendor/autoload.php';

$toolbox = new GPXToolbox();
$gpx = $toolbox::load('input.gpx');

foreach ($gpx->trk as $trk) {
    echo sprintf('<pre>%s</pre>', print_r($trk->toArray(), true));
}
