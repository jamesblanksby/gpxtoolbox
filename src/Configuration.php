<?php

namespace GPXToolbox;

class Configuration
{
    /**
     * Number of decimal places for latitude and longitude values.
     * Six decimal places provide approximately 10cm precision.
     * @var integer
     */
    public $coordinatePrecision = 6;

    /**
     * Number of decimal places for distance values.
     * @var integer
     */
    public $distancePrecision = 2;

    /**
     * Number of decimal places for elevation values.
     * @var integer
     */
    public $elevationPrecision = 2;

    /**
     * Minimum distance threshold between points in meters.
     * Disabled when set to false.
     * @var float|boolean
     */
    public $distanceThreshold = 2;

    /**
     * Minimum elevation threshold between points in meters.
     * Disabled when set to false.
     * @var float|boolean
     */
    public $elevationThreshold = 5;

    /**
     * Minimum distance in meters to be covered between points to be considered moving.
     * Used in conjunction with $movingDurationThreshold.
     * @var float
     */
    public $movingDistanceThreshold = 0.25;

    /**
     * Maximum duration in seconds between points to be considered moving.
     * Used in conjunction with $movingDistanceThreshold.
     * @var float
     */
    public $movingDurationThreshold = 5;

    /**
     * Number of decimal places for pace values.
     * @var integer
     */
    public $pacePrecision = 2;

    /**
     * Number of decimal places for speed values.
     * @var integer
     */
    public $speedPrecision = 2;

    /**
     * Configuration constructor.
     *
     * @param array $configuration
     */
    public function __construct(array $configuration = [])
    {
        foreach ($configuration as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * Set the coordinate precision.
     *
     * @param int $coordinatePrecision
     * @return $this
     */
    public function setCoordinatePrecision(int $coordinatePrecision)
    {
        $this->coordinatePrecision = $coordinatePrecision;

        return $this;
    }

    /**
     * Set the distance precision.
     *
     * @param int $distancePrecision
     * @return $this
     */
    public function setDistancePrecision(int $distancePrecision)
    {
        $this->distancePrecision = $distancePrecision;

        return $this;
    }

    /**
     * Set the distance threshold.
     *
     * @param float|bool $distanceThreshold
     * @return $this
     */
    public function setDistanceThreshold($distanceThreshold)
    {
        $this->distanceThreshold = $distanceThreshold;

        return $this;
    }

    /**
     * Set the elevation precision.
     *
     * @param int $elevationPrecision
     * @return $this
     */
    public function setElevationPrecision(int $elevationPrecision)
    {
        $this->elevationPrecision = $elevationPrecision;

        return $this;
    }

    /**
     * Set the elevation threshold.
     *
     * @param float|bool $elevationThreshold
     * @return $this
     */
    public function setElevationThreshold($elevationThreshold)
    {
        $this->elevationThreshold = $elevationThreshold;

        return $this;
    }

    /**
     * Set the moving distance threshold.
     *
     * @param float $movingDistanceThreshold
     * @return $this
     */
    public function setMovingDistanceThreshold(float $movingDistanceThreshold)
    {
        $this->movingDistanceThreshold = $movingDistanceThreshold;

        return $this;
    }

    /**
     * Set the moving duration threshold.
     *
     * @param float $movingDurationThreshold
     * @return $this
     */
    public function setMovingDurationThreshold(float $movingDurationThreshold)
    {
        $this->movingDurationThreshold = $movingDurationThreshold;

        return $this;
    }

    /**
     * Set the pace precision.
     *
     * @param int $pacePrecision
     * @return $this
     */
    public function setPacePrecision(int $pacePrecision)
    {
        $this->pacePrecision = $pacePrecision;

        return $this;
    }

    /**
     * Set the speed precision.
     *
     * @param int $speedPrecision
     * @return $this
     */
    public function setSpeedPrecision(int $speedPrecision)
    {
        $this->speedPrecision = $speedPrecision;

        return $this;
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
     * Get the distance threshold.
     *
     * @return float|bool
     */
    public function getDistanceThreshold()
    {
        return $this->distanceThreshold;
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
     * Get the elevation threshold.
     *
     * @return float|bool
     */
    public function getElevationThreshold()
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
