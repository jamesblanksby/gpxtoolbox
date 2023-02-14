<?php

namespace GPXToolbox\Types\Extensions;

use GPXToolbox\Parsers\ExtensionParser;

abstract class ExtensionAbstract implements ExtensionInterface
{
    /**
     * @inheritDoc
     */
    public static $EXTENSION_NAME = '';

    /**
     * @inheritDoc
     */
    public static $EXTENSION_PREFIX = null;

    /**
     * @inheritDoc
     */
    public static $EXTENSION_NAMESPACE = '';

    /**
     * @inheritDoc
     */
    public static $EXTENSION_SCHEMA = '';

    /**
     * @inheritDoc
     */
    public static $EXTENSION_PARSER = '';

    /**
     * @inheritDoc
     */
    final public function __construct()
    {
        $classname = get_class($this);

        if (!in_array($classname, ExtensionParser::$PARSED_EXTENSIONS)) {
            ExtensionParser::$PARSED_EXTENSIONS []= $this;
        }
    }
}
