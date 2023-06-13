# 🗺 GPXToolbox

[![Maintainability](https://img.shields.io/codeclimate/maintainability/jamesblanksby/gpxtoolbox)](https://codeclimate.com/github/jamesblanksby/gpxtoolbox)
[![Latest version](https://img.shields.io/packagist/v/jamesblanksby/gpxtoolbox)](https://packagist.org/packages/jamesblanksby/gpxtoolbox)
[![Downloads](https://img.shields.io/packagist/dm/jamesblanksby/gpxtoolbox)](https://packagist.org/packages/jamesblanksby/gpxtoolbox)

A simple library for creating, parsing and modifying [GPX files](https://en.wikipedia.org/wiki/GPS_Exchange_Format).


## Features

* Full support for [official specification](http://www.topografix.com/GPX/1/1).
* High performance polyline simplification.
* Statistics calculation.
* Extension interface.
* GPX, [GeoJSON](https://geojson.org), JSON and PHP Array output.

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

* Garmin [TrackPointExtensionv1](https://www8.garmin.com/xmlschemas/TrackPointExtensionv1.xsd)
* Garmin [TrackPointExtensionv2](https://www8.garmin.com/xmlschemas/TrackPointExtensionv2.xsd)
* GPX [StyleLineExtension](http://www.topografix.com/GPX/gpx_style/0/2/gpx_style.xsd)


## 📖 Simple Example

Load a GPX file and retrieve statistical data.

```php
<?php

include 'vendor/autoload.php';

$toolbox = new GPXToolbox\GPXToolbox();
$gpx = $toolbox::load('examples/input.gpx');

$stats = $gpx->getStats();

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
    [gainElevation] => 115.2
    [lossElevation] => 92.2
    [averagePace] => 116.4
    [averageSpeed] => 30.93
)
```

See the [examples](./examples) directory for more…

## 🤖 API

### GPXToolbox\GPXToolbox

#### `GPXToolbox::load(string $filename)`

Loads and parses a GPX file.

####  Parameters:

* `$filename`: Name of the GPX file to read.

#### Return values:

* `GPX`: Parsed GPX data.

<hr>

#### `GPXToolbox::parse(string $xml)`

Parses a GPX XML string.

####  Parameters:

* `$xml`: A well-formed GPX XML string.

#### Return values:

* `GPX`: Parsed GPX data.

<hr>

#### `GPXToolbox::addExtension(string $extension)`

Add extension interface.

* `$extension`: The fully qualified name of an extension implementing the `ExtensionInterface` class.

##### Return values:

* `GPXToolbox`: `$this` for method chaining.


### GPXToolbox\Types\GPX

#### `GPX::addWaypoint(Point $wpt)`

Add GPX waypoint.

* `$wpt`: Waypoint `Point` object.

##### Return values:

* `GPX`: `$this` for method chaining.

<hr>

#### `GPX::addRoute(Route $rte)`

Add GPX route.

* `$rte`: `Route` object.

##### Return values:

* `GPX`: `$this` for method chaining.

<hr>

#### `GPX::addTrack(Track $trk)`

Add GPX track.

* `$wpt`: `Track` object.

##### Return values:

* `GPX`: `$this` for method chaining.

<hr>

#### `GPX::addExtension(ExtensionAbstract $extension)`

Add extension interface.

* `$extension`: An extension implementing the `ExtensionInterface` class.

##### Return values:

* `GPX`: `$this` for method chaining.

<hr>

#### `GPX::getPoints()`

Returns all track points points recursively. `getPoints()` may also be called on `Track` and `Segment`.

#### Return values:

* `array`: Array containing GPX track points.

<hr>

#### `GPX::getBounds()`

Returns the geographical bounds for a given GPX file. `getBounds()` may also be called on `Track` and `Segment`.

#### Return values:

* `array`: Array containing longitude and latitude bounds.

<hr>

#### `GPX::getStats()`

Returns the statistical data such as distance, moving time and elevation gain for a given GPX file. `getStats()` may also be called on `Track` and `Segment`.

#### Return values:

* `Stats`: Stats data.

<hr>

#### `GPX::simplify([float $tolerance, bool $highestQuality,])`;

Simplifies a polyline using a combination of [Douglas-Peucker](http://en.wikipedia.org/wiki/Ramer-Douglas-Peucker_algorithm) and Radial Distance algorithms. `simplify()` may also be called on `Track` and `Segment` with the same parameters.

####  Parameters:

* `$tolerance`: Affects the amount of simplification [Default: `1.0`] *(Optional)*.
* `$highestQuality`: Excludes distance-based preprocessing step which leads to highest quality simplification but runs ~10-20 times slower [Default: `false`] *(Optional)*.

#### Return values:

* `GPX`: GPX data with simplified polyline points.

<hr>

#### `GPX::save(string $path, string $format)`

Save GPX to file.

* `$path`: Path to the file where to save the data.
* `$format`: Output format of saved data.

#### Return values:

* `int|boolean`: The number of bytes that were saved to the file, or `false` on failure. 

<hr>

#### `GPX::toXML()`

The XML representation of GPX file.

#### Return values:

* `DOMDocument`: GPX data as an XML document.

<hr>

#### `GPX::toGeoJSON()`

GeoJSON encoded representation of GPX file.

* `string`: GPX data as a GeoJSON string.

<hr>

#### `GPX::toJSON()`

JSON encoded representation of GPX file.

* `string`: GPX data as a JSON string.

<hr>

#### `GPX::toArray()`

Array representation of GPX file.

* `array`: GPX data as a PHP array.


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
