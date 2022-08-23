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
     * XML namespace of extension.
     * @var string|array
     */
    public const EXTENSION_NAMESPACE = '';

    /**
     * XML namespace and element prefix of extension.
     * @var string
     */
    public const EXTENSION_PREFIX = '';

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
