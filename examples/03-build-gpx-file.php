<?php

use GPXToolbox\Types\Extensions\TrackPointV1Extension;
use GPXToolbox\Types\GPX;
use GPXToolbox\Types\Link;
use GPXToolbox\Types\Metadata;
use GPXToolbox\Types\Point;
use GPXToolbox\Types\Segment;
use GPXToolbox\Types\Track;

include '../vendor/autoload.php';

$data_array = [
	[
		'longitude' => -77.02016,
		'latitude' => 38.92747,
		'elevation' => 25.6,
		'hr' => 130,
		'time' => new \DateTime('+ 1 second'),
	],
	[
		'longitude' => -77.02014,
		'latitude' => 38.92760,
		'elevation' => 35.5,
		'hr' => 134,
		'time' => new \DateTime('+ 2 second'),
	],
	[
		'longitude' => -77.02007,
		'latitude' => 38.92767,
		'elevation' => 38.0,
		'hr' => 139,
		'time' => new \DateTime('+ 3 second'),
	],
	[
		'longitude' => -77.02001,
		'latitude' => 38.92773,
		'elevation' => 40.0,
		'hr' => 144,
		'time' => new \DateTime('+ 4 second'),
    ],
    [
		'longitude' => -77.01996,
		'latitude' => 38.92776,
		'elevation' => 40.7,
		'hr' => 161,
		'time' => new \DateTime('+ 5 second'),
	]
];

$gpx = new GPX();

$metadata = new Metadata();
$metadata->time = new \DateTime();
$metadata->desc = 'Example GPX file built using GPXToolbox';

$link = new Link();
$link->href = 'https://github.com/jamesblanksby/gpxtoolbox';
$link->text = 'GPXToolbox';
$metadata->links []= $link;

$gpx->metadata = $metadata;

$trk = new Track();

$trk->name = 'Example Track';

$trkseg = new Segment();

foreach ($data_array as $data) {
    $point = new Point(Point::TRACKPOINT);

	$point->lat = $data['latitude'];
	$point->lon = $data['longitude'];
	$point->ele = $data['elevation'];
	$point->time = $data['time'];

    $extension = new TrackPointV1Extension();
    $extension->hr = $data['hr'];

    $point->extensions []= $extension;

    $trkseg->addPoint($point);
}

$trk->trkseg []= $trkseg;

$gpx->trk []= $trk;

header('Content-Type: application/xml');
echo $gpx->toXML()->saveXML();
