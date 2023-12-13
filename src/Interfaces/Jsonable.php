<?php

namespace GPXToolbox\Interfaces;

interface Jsonable
{
    public function toJson(int $options = 0): string;
}
