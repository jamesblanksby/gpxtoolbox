<?php

namespace GPXToolbox\Tests\Helpers;

use GPXToolbox\Helpers\DistanceHelper;
use GPXToolbox\Types\Point;
use PHPUnit\Framework\TestCase;

final class DistanceHelperTest extends TestCase
{
    /**
     * @return void
     */
    public function testGet2dDistance(): void
    {
        list($a, $b) = $this->providePoints();

        $this->assertEquals(920056.1414369721, DistanceHelper::get2dDistance($a, $b));
    }

    /**
     * @return void
     */
    public function testGet3dDistance(): void
    {
        list($a, $b) = $this->providePoints();

        $this->assertEquals(920056.1415108565, DistanceHelper::get3dDistance($a, $b));
    }

    /**
     * @return void
     */
    public function testGetSquareDistance(): void
    {
        list($a, $b) = $this->providePoints();

        $this->assertEquals(15632.928837366564, DistanceHelper::getSquareDistance($a, $b));
    }

    /**
     * @return void
     */
    public function testGetSquareSegmentDistance(): void
    {
        list($a, $b, $c) = $this->providePoints();

        $this->assertEquals(15623.634095979634, DistanceHelper::getSquareSegmentDistance($a, $b, $c));
    }

    /**
     * @return Point[]
     */
    protected function providePoints(): array
    {
        $a = new Point(Point::WAYPOINT);
        $a->lat = -80.688897;
        $a->lon = -52.525442;
        $a->ele = 29.4;

        $b = new Point(Point::WAYPOINT);
        $b->lat = -92.173776;
        $b->lon = 71.977676;
        $b->ele = 17.74;

        $c = new Point(Point::WAYPOINT);
        $c->lat = 74.810241;
        $c->lon = 83.282911;
        $c->ele = 95.83;

        return [$a, $b, $c,];
    }
}
