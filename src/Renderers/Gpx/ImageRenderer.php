<?php

namespace GPXToolbox\Renderers\Gpx;

use GPXToolbox\Helpers\Gpx\PointHelper;
use GPXToolbox\Models\Gpx;
use GPXToolbox\Models\Gpx\Bounds;
use GPXToolbox\Models\Gpx\Point;
use GPXToolbox\Models\Gpx\PointCollection;
use GPXToolbox\Models\Gpx\RouteCollection;
use GPXToolbox\Models\Gpx\TrackCollection;

class ImageRenderer
{
    /**
     * Image width in pixels.
     * @var int
     */
    public int $width = 1024;

    /**
     * Image height in pixels.
     * @var int
     */
    public int $height = 768;

    /**
     * Background color represented as an RGB array.
     * @var array
     */
    public array $color = [255, 255, 255,];

    /**
     * Stroke width for route lines in pixels.
     * @var int
     */
    public int $routeWidth = 2;

    /**
     * Color of route lines represented as an RGB array.
     * @var array
     */
    public array $routeColor = [0, 255, 0,];

    /**
     * Stroke width for track lines in pixels.
     * @var int
     */
    public int $trackWidth = 4;

    /**
     * Color of track lines represented as an RGB array.
     * @var array
     */
    public array $trackColor = [255, 0, 0,];

    /**
     * Diameter of point markers in pixels.
     * @var int
     */
    public int $pointSize = 12;

    /**
     * Color of point markers represented as an RGB array.
     * @var array
     */
    public array $pointColor = [0, 0, 255,];

    /**
     * Geographic bounds used for projecting coordinates into pixel space.
     * @var Bounds|null
     */
    protected ?Bounds $bounds = null;

    /**
     * Horizontal scale factor used to convert longitude values into pixels.
     * @var float|null
     */
    protected ?float $scaleX = null;

    /**
     * Vertical scale factor used to convert latitude values into pixels.
     * @var float|null
     */
    protected ?float $scaleY = null;

    /**
     * ImageRenderer constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        foreach ($options as $key => $value) {
            if (!property_exists($this, $key)) {
                continue;
            }

            $this->{$key} = $value;
        }
    }

    /**
     * Render a GPX object into a GD image resource.
     *
     * @param Gpx $gpx
     * @return \GdImage
     */
    public function render(Gpx $gpx): \GdImage
    {
        $image = $this->createImage();

        $this->setContext($gpx->getBounds());

        $image = $this->renderRoutes($image, $gpx->getRoutes());
        $image = $this->renderTracks($image, $gpx->getTracks());
        $image = $this->renderPoints($image, $gpx->getPoints());

        return $image;
    }

    /**
     * Render individual GPX points onto the image.
     *
     * @param \GdImage $image
     * @param PointCollection $points
     * @return \GdImage
     */
    public function renderPoints(\GdImage $image, PointCollection $points): \GdImage
    {
        $reset = $this->ensureContext($points);

        foreach ($points as $point) {
            $image = $this->drawPoint($image, $point, $this->pointSize, $this->pointColor);
        }

        if ($reset) {
            $this->resetContext();
        }

        return $image;
    }

    /**
     * Render GPX routes as polyline segments.
     *
     * @param \GdImage $image
     * @param RouteCollection $routes
     * @return \GdImage
     */
    public function renderRoutes(\GdImage $image, RouteCollection $routes): \GdImage
    {
        $points = $routes->getPoints();
        $reset = $this->ensureContext($points);

        $image = $this->drawLine($image, $points, $this->routeWidth, $this->routeColor);

        if ($reset) {
            $this->resetContext();
        }

        return $image;
    }

    /**
     * Render GPX tracks as polyline segments.
     *
     * @param \GdImage $image
     * @param RouteCollection $routes
     * @return \GdImage
     */
    public function renderTracks(\GdImage $image, TrackCollection $tracks): \GdImage
    {
        $points = $tracks->getPoints();
        $reset = $this->ensureContext($points);

        $image = $this->drawLine($image, $points, $this->trackWidth, $this->trackColor);

        if ($reset) {
            $this->resetContext();
        }

        return $image;
    }

    /**
     * @return \GdImage
     */
    protected function createImage(): \GdImage
    {
        $image = imagecreatetruecolor($this->width, $this->height);

        $color = imagecolorallocate($image, ...$this->color);
        imagefill($image, 0, 0, $color);

        return $image;
    }

    /**
     * @param \GdImage $image
     * @param PointCollection $points
     * @param int $size
     * @param array $color
     * @return \GdImage
     */
    protected function drawPoint(\GdImage $image, Point $point, int $size, array $color): \GdImage
    {
        [$x, $y,] = $point->getCoordinates();

        $px = (int) (($x - $this->bounds->minlon) * $this->scaleX);
        $py = (int) ($this->height - (($y - $this->bounds->minlat) * $this->scaleY));

        $color = imagecolorallocate($image, ...$color);
        imagefilledellipse($image, $px, $py, $size, $size, $color);

        return $image;
    }

    /**
     * @param \GdImage $image
     * @param PointCollection $points
     * @return \GdImage
     */
    protected function drawLine(\GdImage $image, PointCollection $points, int $width, array $color): \GdImage
    {
        $count = $points->count();

        if ($count <= 2) {
            return $image;
        }

        $prevPoint = $points->first();

        imagesetthickness($image, $width);
        $color = imagecolorallocate($image, ...$color);

        for ($a = 1; $a < $count; $a++) {
            $point = $points->get($a);

            [$x1, $y1,] = $prevPoint->getCoordinates();
            [$x2, $y2,] = $point->getCoordinates();

            $px1 = (int) (($x1 - $this->bounds->minlon) * $this->scaleX);
            $py1 = (int) ($this->height - (($y1 - $this->bounds->minlat) * $this->scaleY));
            $px2 = (int) (($x2 - $this->bounds->minlon) * $this->scaleX);
            $py2 = (int) ($this->height - (($y2 - $this->bounds->minlat) * $this->scaleY));

            imageline($image, $px1, $py1, $px2, $py2, $color);

            $prevPoint = $point;
        }

        return $image;
    }

    /**
     * @param PointCollection $points
     * @return bool
     */
    protected function ensureContext(PointCollection $points): bool
    {
        if (!$this->hasContext()) {
            $this->setContext(PointHelper::getBounds($points));

            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    protected function hasContext(): bool
    {
        return isset($this->bounds, $this->scaleX, $this->scaleY);
    }

    /**
     * @param Bounds $bounds
     * @return void
     */
    protected function setContext(Bounds $bounds): void
    {
        $this->bounds = $bounds;
        list($this->scaleX, $this->scaleY) = $this->getScale($this->bounds);
    }

    protected function resetContext(): void
    {
        $this->bounds = null;
        $this->scaleX = null;
        $this->scaleY = null;
    }

    /**
     * @param Bounds $bounds
     * @return array
     */
    protected function getScale(Bounds $bounds): array
    {
        return [
            ($this->width / ($bounds->maxlon - $bounds->minlon)),
            ($this->height / ($bounds->maxlat - $bounds->minlat)),
        ];
    }
}
