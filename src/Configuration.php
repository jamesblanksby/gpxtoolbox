<?php

namespace GPXToolbox;

class Configuration
{
    /**
     * Number of decimal places for coordinates.
     *
     * @var int
     */
    public int $coordinatePrecision = 6;

    /**
     * Number of decimal places for distance measurements.
     *
     * @var int
     */
    public int $distancePrecision = 2;

    /**
     * Number of decimal places for elevation measurements.
     *
     * @var int
     */
    public int $elevationPrecision = 2;

    /**
     * Distance threshold for certain calculations.
     *
     * @var float
     */
    public float $distanceThreshold = 2.0;

    /**
     * Elevation threshold for certain calculations.
     *
     * @var float
     */
    public float $elevationThreshold = 5.0;

    /**
     * Distance threshold for moving calculations.
     *
     * @var float
     */
    public float $movingDistanceThreshold = 0.25;

    /**
     * Duration threshold for moving calculations.
     *
     * @var float
     */
    public float $movingDurationThreshold = 5.0;

    /**
     * Number of decimal places for pace calculations.
     *
     * @var int
     */
    public int $pacePrecision = 2;

    /**
     * Number of decimal places for speed calculations.
     *
     * @var int
     */
    public int $speedPrecision = 2;

    /**
     * Configuration constructor.
     *
     * @param array $configuration
     */
    public function __construct(array $configuration = [])
    {
        foreach ($configuration as $key => $value) {
            if (!property_exists($this, $key)) {
                continue;
            }

            $this->{$key} = $value;
        }
    }

    /**
     * Get the coordinate precision.
     *
     * @return int
     */
    public function getCoordinatePrecision(): int
    {
        return $this->coordinatePrecision;
    }

    /**
     * Get the distance precision.
     *
     * @return int
     */
    public function getDistancePrecision(): int
    {
        return $this->distancePrecision;
    }

    /**
     * Get the elevation precision.
     *
     * @return int
     */
    public function getElevationPrecision(): int
    {
        return $this->elevationPrecision;
    }

    /**
     * Get the distance threshold.
     *
     * @return float
     */
    public function getDistanceThreshold(): float
    {
        return $this->distanceThreshold;
    }

    /**
     * Get the elevation threshold.
     *
     * @return float
     */
    public function getElevationThreshold(): float
    {
        return $this->elevationThreshold;
    }

    /**
     * Get the moving distance threshold.
     *
     * @return float
     */
    public function getMovingDistanceThreshold(): float
    {
        return $this->movingDistanceThreshold;
    }

    /**
     * Get the moving duration threshold.
     *
     * @return float
     */
    public function getMovingDurationThreshold(): float
    {
        return $this->movingDurationThreshold;
    }

    /**
     * Get the pace precision.
     *
     * @return int
     */
    public function getPacePrecision(): int
    {
        return $this->pacePrecision;
    }

    /**
     * Get the speed precision.
     *
     * @return int
     */
    public function getSpeedPrecision(): int
    {
        return $this->speedPrecision;
    }
}
