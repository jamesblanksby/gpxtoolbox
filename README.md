# 🗺 GPXToolbox

A simple library for creating, parsing and modifying [GPX files](https://en.wikipedia.org/wiki/GPS_Exchange_Format).


## Features

* Full* support for [official specification](http://www.topografix.com/GPX/1/1).
* High performance polyline simplification.
* GPX, GeoJSON, JSON and PHP Array output.

\* Extensions coming soon!


## ⚡️ Installation

Using [Composer](https://getcomposer.org):

```php
$ composer require jamesblanksby/gpxtoolbox
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

### `GPX::simplify([float $tolerance, bool $highestQuality,])`;

Simplifies a polyline using a combination of [Douglas-Peucker](http://en.wikipedia.org/wiki/Ramer-Douglas-Peucker_algorithm) and Radial Distance algorithms. `simplify` may also be called on `Track` and `Segment` with the same parameters.

####  Parameters:

* `$tolerance`: Affects the amount of simplification [Default: `1.0`] *(Optional)*.
* `$highestQuality`: Excludes distance-based preprocessing step which leads to highest quality simplification but runs ~10-20 times slower [Default: `false`] *(Optional)*.

#### Return values:

* `GPX`: GPX data with simplified polyline points.


## 🔧 Configuration

| Name           | Description               | Type    | Default | Example                             |
|----------------|---------------------------|---------|---------|-------------------------------------|
| `PRETTY_PRINT` | Pretty print when saving. | Boolean | true    | `GPXToolbox::$PRETTY_PRINT = true;` |


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
