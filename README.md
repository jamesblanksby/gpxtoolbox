# 🗺 GPXToolbox

[![Maintainability](https://img.shields.io/codeclimate/maintainability/jamesblanksby/gpxtoolbox)](https://codeclimate.com/github/jamesblanksby/gpxtoolbox)
[![Latest version](https://img.shields.io/packagist/v/jamesblanksby/gpxtoolbox)](https://packagist.org/packages/jamesblanksby/gpxtoolbox)
[![Downloads](https://img.shields.io/packagist/dm/jamesblanksby/gpxtoolbox)](https://packagist.org/packages/jamesblanksby/gpxtoolbox)

A library for creating, parsing, and modifying [GPX files](https://en.wikipedia.org/wiki/GPS_Exchange_Format).

## Features

* Full* support for [official specification](http://www.topografix.com/GPX/1/1).
* High performance polyline simplification.
* Statistics analysis.
* Activity splits.
* GPX, JSON, [GeoJSON](https://geojson.org) and PHP Array output.

\* Extensions coming soon!

### Statistics Analysis

* Smoothed distance
* Moving duration
* Total duration
* Minimum elevation
* Maximum elevation
* Elevation gain
* Elevation loss
* Average pace (minutes per km)
* Average speed (kph)

## ⚡️ Installation

You can install **GPXToolbox** with **[composer](https://getcomposer.org)**.

```shell
$ composer require jamesblanksby/gpxtoolbox
```

## 📖 Simple Example

Load a GPX file and retrieve statistical analysis.

```php
<?php

use GPXToolbox\GPXToolbox;

include 'vendor/autoload.php';

$toolbox = new GPXToolbox();
$gpx = $toolbox->load('examples/input.gpx');

$statistics = $gpx->getTracks()->getStatistics();

echo sprintf('<pre>%s</pre>', print_r($statistics->toArray(), true));
```

The above example will output:

```
Array
(
    [distance] => 51946.58
    [movingDuration] => 29940
    [totalDuration] => 32678
    [minElevation] => 64.32
    [maxElevation] => 240.6
    [gainElevation] => 2113.4
    [lossElevation] => 2104.17
    [averagePace] => 576.36
    [averageSpeed] => 6.25
)
```

See the [examples](./examples) directory for more…
