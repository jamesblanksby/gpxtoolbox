<?php

namespace GPXToolbox\Models\Gpx;

final class Datetime extends \DateTimeImmutable
{
    public function toString(): string
    {
        return $this->format(\DateTimeInterface::ATOM);
    }
}
