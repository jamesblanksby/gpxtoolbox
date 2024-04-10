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
}
