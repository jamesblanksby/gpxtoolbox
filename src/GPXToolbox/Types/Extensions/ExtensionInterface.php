<?php

namespace GPXToolbox\Types\Extensions;

interface ExtensionInterface
{
    /**
     * Array representation of extension data.
     * @return mixed[]
     */
    public function toArray(): array;
}
