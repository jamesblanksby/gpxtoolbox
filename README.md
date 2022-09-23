# 🗺 GPXToolbox

A simple library for creating, parsing and modifying [GPX files](https://en.wikipedia.org/wiki/GPS_Exchange_Format).


## Features

* Full support for [official specification](http://www.topografix.com/GPX/1/1).
* High performance polyline simplification.
* Statistics calculation.
* Extension interface.
* GPX, GeoJSON, JSON and PHP Array output.

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

### Extension Interface

* [GPX StyleLineExtension](http://www.topografix.com/GPX/gpx_style/0/2/gpx_style.xsd)
* Garmin TrackPointExtension ([v1](https://www8.garmin.com/xmlschemas/TrackPointExtensionv1.xsd) and [v2](https://www8.garmin.com/xmlschemas/TrackPointExtensionv2.xsd))


## 📖 Simple Example

Load a GPX file and retrieve statistical data.

```php
<?php

include 'vendor/autoload.php';

$toolbox = new GPXToolbox\GPXToolbox();
$gpx = $toolbox::load('examples/input.gpx');

$stats = $gpx->stats();

echo sprintf('<pre>%s</pre>', print_r($stats, true));
```

The above example will output:

```
GPXToolbox\Models\Stats Object
(
    [distance] => 3127.27
    [movingDuration] => 364
    [totalDuration] => 948
    [minElevation] => 25.6
    [maxElevation] => 82.8
    [elevationGain] => 115.2
    [elevationLoss] => 92.2
    [averagePace] => 116.4
    [averageSpeed] => 30.93
)
```

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

### `GPXToolbox::addExtension(string $extension)`

Add extension interface.

*  `$extension`: An extension implementing the `ExtensionInterface` class.

##### Return values:

* `GPXToolbox`: `$this` for method chaining.

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

Use `GPXToolbox`'s static variables to modify behaviour.

| Name                         | Type               | Default |
|------------------------------|--------------------|---------|
| `$COORDINATE_PRECISION`      | `integer`          | `6`     |
| `$DISTANCE_PRECISION`        | `integer`          | `2`     |
| `$DISTANCE_THRESHOLD`        | `float`\|`boolean` | `2`     |
| `$ELEVATION_PRECISION`       | `integer`          | `2`     |
| `$ELEVATION_THRESHOLD`       | `float`\|`boolean` | `5`     |
| `$PACE_PRECISION`            | `integer`          | `2`     |
| `$SPEED_PRECISION`           | `integer`          | `2`     |
| `$MOVING_DISTANCE_THRESHOLD` | `float`            | `0.25`  |
| `$MOVING_DURATION_THRESHOLD` | `float`            | `5`     |
| `$PRETTY_PRINT`              | `boolean`          | `true`  |
