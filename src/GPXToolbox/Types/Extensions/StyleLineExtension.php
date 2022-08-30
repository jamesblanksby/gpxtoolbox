<?php

namespace GPXToolbox\Types\Extensions;

use GPXToolbox\Parsers\Extensions\StyleLineExtensionParser;

class StyleLineExtension implements ExtensionInterface
{
    /**
     * Name of extension.
     * @var string
     */
    public const EXTENSION_NAME = 'line';

    /**
     * Name of extension prefix
     * @var string|null
     */
    public const EXTENSION_PREFIX = null;

    /**
     * XML namespace of extension.
     * @var string
     */
    public const EXTENSION_NAMESPACE = 'http://www.topografix.com/GPX/gpx_style/0/2';

    /**
     * XML schema definition.
     * @var string
     */
    public const EXTENSION_SCHEMA = 'http://www.topografix.com/GPX/gpx_style/0/2/gpx_style.xsd';

    /**
     * Extension parser fully qualified class name.
     * @var string
     */
    public const EXTENSION_PARSER = StyleLineExtensionParser::class;

    /**
     * Hexadecimal RGB color.
     * @var string
     */
    public $color = null;

    /**
     * Line opacity.
     * @var float
     */
    public $opacity = null;

    /**
     * Width of the line in pixels.
     * @var float
     */
    public $width = null;

    /**
     * Line pattern style.
     * @var string
     */
    public $pattern = null;

    /**
     * The shape used to draw the end points of the line.
     * @var string
     */
    public $linecap = null;

    /**
     * List of marks and spaces in pixels.
     * @var array
     */
    public $dasharray = null;

    /**
     * Array representation of line style extension data.
     * @return array
     */
    public function toArray(): array
    {
        return [
            'color'     => $this->color,
            'opacity'   => $this->opacity,
            'width'     => $this->width,
            'pattern'   => $this->pattern,
            'linecap'   => $this->linecap,
            'dasharray' => $this->dasharray,
        ];
    }
}
