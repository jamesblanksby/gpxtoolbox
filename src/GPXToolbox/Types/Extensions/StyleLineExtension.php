<?php

namespace GPXToolbox\Types\Extensions;

use GPXToolbox\Parsers\Extensions\StyleLineExtensionParser;

class StyleLineExtension extends ExtensionAbstract
{
    /**
     * @inheritDoc
     * @var string
     */
    public static $EXTENSION_NAME = 'line';

    /**
     * @inheritDoc
     * @var string
     */
    public static $EXTENSION_PREFIX = null;

    /**
     * @inheritDoc
     * @var string
     */
    public static $EXTENSION_NAMESPACE = 'http://www.topografix.com/GPX/gpx_style/0/2';

    /**
     * @inheritDoc
     * @var string
     */
    public static $EXTENSION_SCHEMA = 'http://www.topografix.com/GPX/gpx_style/0/2/gpx_style.xsd';

    /**
     * @inheritDoc
     * @var string
     */
    public static $EXTENSION_PARSER = StyleLineExtensionParser::class;

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
     * @inheritDoc
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
