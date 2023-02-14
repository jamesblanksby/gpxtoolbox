<?php

namespace GPXToolbox\Types\Extensions;

use GPXToolbox\Interfaces\ArraySerializableInterface;

interface ExtensionInterface extends ArraySerializableInterface
{
    /**
     * Name of extension.
     * @var string
     */
    public static $EXTENSION_NAME;

    /**
     * Name of extension prefix.
     * @var string|null
     */
    public static $EXTENSION_PREFIX;

    /**
     * XML namespace of extension.
     * @var string
     */
    public static $EXTENSION_NAMESPACE;

    /**
     * XML schema definition.
     * @var string
     */
    public static $EXTENSION_SCHEMA;

    /**
     * Extension parser fully qualified class name.
     * @var string
     */
    public static $EXTENSION_PARSER;
}
