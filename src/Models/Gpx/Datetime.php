<?php

namespace GPXToolbox\Models\Gpx;

class Datetime extends \DateTimeImmutable
{
    /**
     * Convert the datetime to a string.
     *
     * @return string
     */
    public function toString(): string
    {
        return $this->format(\DateTimeInterface::ATOM);
    }
}
