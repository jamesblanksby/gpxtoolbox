<?php

namespace GPXToolbox\Types\Extensions;

interface ExtensionInterface
{
    /**
     * Name of extension.
     * @var string;
     */
    public const EXTENSION_NAME = '';

    /**
     * Name of extension prefix
     * @var string|null
     */
    public const EXTENSION_PREFIX = null;

    /**
     * XML namespace of extension.
     * @var string
     */
    public const EXTENSION_NAMESPACE = '';

    /**
     * XML schema definition.
     * @var string
     */
    public const EXTENSION_SCHEMA = '';

    /**
     * Extension parser fully qualified class name.
     * @var string
     */
    public const EXTENSION_PARSER = '';

    /**
     * Array representation of extension data.
     * @return array
     */
    public function toArray(): array;
}
