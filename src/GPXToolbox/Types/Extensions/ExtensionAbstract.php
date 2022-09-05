<?php

namespace GPXToolbox\Types\Extensions;

use GPXToolbox\Parsers\ExtensionParser;

abstract class ExtensionAbstract implements ExtensionInterface
{
    /**
     * Name of extension.
     * @var string;
     */
    public static $EXTENSION_NAME = '';

    /**
     * Name of extension prefix.
     * @var string|null
     */
    public static $EXTENSION_PREFIX = null;

    /**
     * XML namespace of extension.
     * @var string
     */
    public static $EXTENSION_NAMESPACE = '';

    /**
     * XML schema definition.
     * @var string
     */
    public static $EXTENSION_SCHEMA = '';

    /**
     * Extension parser fully qualified class name.
     * @var string
     */
    public static $EXTENSION_PARSER = '';

    /**
     * ExtensionAbstract constructor.
     */
    final public function __construct()
    {
        $classname = get_class($this);

        if (!in_array($classname, ExtensionParser::$PARSED_EXTENSIONS)) {
            ExtensionParser::$PARSED_EXTENSIONS[] = $classname;
        }
    }
}
