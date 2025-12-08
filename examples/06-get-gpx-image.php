<?php

use GPXToolbox\GPXToolbox;

include '../vendor/autoload.php';

$toolbox = new GPXToolbox();
$gpx = $toolbox->load('input.gpx');

$image = $gpx->toImage();

header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
