<?php

namespace GPXToolbox;

final class Configuration
{
    public int $coordinatePrecision = 6;

    public int $distancePrecision = 2;

    public int $elevationPrecision = 2;

    public float $distanceThreshold = 2.0;

    public float $elevationThreshold = 5.0;

    public float $movingDistanceThreshold = 0.25;

    public float $movingDurationThreshold = 5.0;

    public int $pacePrecision = 2;

    public int $speedPrecision = 2;

    public function __construct(array $configuration = [])
    {
        foreach ($configuration as $key => $value) {
            if (!property_exists($this, $key)) {
                continue;
            }

            $this->{$key} = $value;
        }
    }

    public function getCoordinatePrecision(): int
    {
        return $this->coordinatePrecision;
    }

    public function getDistancePrecision(): int
    {
        return $this->distancePrecision;
    }

    public function getElevationPrecision(): int
    {
        return $this->elevationPrecision;
    }

    public function getDistanceThreshold(): float
    {
        return $this->distanceThreshold;
    }

    public function getElevationThreshold(): float
    {
        return $this->elevationThreshold;
    }

    public function getMovingDistanceThreshold(): float
    {
        return $this->movingDistanceThreshold;
    }

    public function getMovingDurationThreshold(): float
    {
        return $this->movingDurationThreshold;
    }

    public function getPacePrecision(): int
    {
        return $this->pacePrecision;
    }

    public function getSpeedPrecision(): int
    {
        return $this->speedPrecision;
    }
}
