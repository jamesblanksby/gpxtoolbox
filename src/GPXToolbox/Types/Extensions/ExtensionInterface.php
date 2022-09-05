<?php

namespace GPXToolbox\Types\Extensions;

interface ExtensionInterface
{
    /**
     * Array representation of extension data.
     * @return array
     */
    public function toArray(): array;
}
