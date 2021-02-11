# 🗺 GPXToolbox

A simple library for creating, parsing and modifying [GPX files](https://en.wikipedia.org/wiki/GPS_Exchange_Format).


## Features

* Full* support for [official specification](http://www.topografix.com/GPX/1/1).
* High performance polyline simplification.
* Statistics calculation.
* GPX, GeoJSON, JSON and PHP Array output.

\* Extensions coming soon!

### Statistics calculation

* Smoothed distance
* Moving duration
* Total duration
* Minimum elevation
* Maximum elevation
* Elevation gain
* Elevation loss
* Average pace (minutes per km)
* Average speed (kph)

## 🤖 API

### `GPXToolbox::load(string $filename)`

Loads and parses a GPX file.

####  Parameters:

* `$filename`: Name of the GPX file to read.

#### Return values:

* `GPX`: Parsed GPX data.

<hr>

### `GPXToolbox::parse(string $xml)`

Parses a GPX XML string.

####  Parameters:

* `$xml`: A well-formed GPX XML string.

#### Return values:

* `GPX`: Parsed GPX data.

<hr>

### `GPX::bounds()`

Returns the geographical bounds for a given GPX file. `bounds()` may also be called on `Track` and `Segment`.

#### Return values:

* `array`: Array containing longitude and latitude bounds.

<hr>

### `GPX::stats()`

Returns the statistical data such as distance, moving time and elevation gain for a given GPX file. `stats()` may also be called on `Track` and `Segment`.

#### Return values:

* `Stats`: Stats data.

<hr>

### `GPX::simplify([float $tolerance, bool $highestQuality,])`;

Simplifies a polyline using a combination of [Douglas-Peucker](http://en.wikipedia.org/wiki/Ramer-Douglas-Peucker_algorithm) and Radial Distance algorithms. `simplify()` may also be called on `Track` and `Segment` with the same parameters.

####  Parameters:

* `$tolerance`: Affects the amount of simplification [Default: `1.0`] *(Optional)*.
* `$highestQuality`: Excludes distance-based preprocessing step which leads to highest quality simplification but runs ~10-20 times slower [Default: `false`] *(Optional)*.

#### Return values:

* `GPX`: GPX data with simplified polyline points.


## 🔧 Configuration

| Name                        | Type               | Default   |
|-----------------------------|--------------------|-----------|
| `PRETTY_PRINT`              | `boolean`          | `true`    |
| `DISTANCE_THRESHOLD`        | `float`\|`boolean` | `2`       |
| `MOVING_DISTANCE_THRESHOLD` | `float`            | `0.25`    |
| `MOVING_DURATION_THRESHOLD` | `float`            | `5`       |
| `ELEVATION_THRESHOLD`       | `float`\|`boolean` | `5`       |


## 📖 Examples

Read a GPX file and output tracks & track segments.

```php
<?php

use GPXToolbox\GPXToolbox;

$gpx = GPXToolbox::load('sample.gpx');

foreach ($gpx->trk as $trk) {
    var_dump($trk->toArray());

    foreach ($trk->trkseg as $trkseg) {
        $trk->toArray();
    }
}
```

Writing to file.

```php
<?php

use GPXToolbox\GPXToolbox;

$gpx = GPXToolbox::load('sample.gpx');

// GPX
$gpx->save('output.gpx', GPXToolbox::FORMAT_GPX);

// JSON
$gpx->save('output.json', GPXToolbox::FORMAT_JSON);
```
