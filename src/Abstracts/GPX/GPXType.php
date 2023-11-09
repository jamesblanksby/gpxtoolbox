<?php

namespace GPXToolbox\Abstracts\GPX;

use GPXToolbox\Abstracts\Model;

abstract class GPXType extends Model
{
    /**
     * Convert the GPX object attributes to an XML string.
     *
     * @return string
     */
    public function toXml(): string
    {
        return '';
    }
}
