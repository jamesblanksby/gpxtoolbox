<?php

namespace GPXToolbox\Tests\Helpers;

use GPXToolbox\Helpers\GeoHelper;
use GPXToolbox\Types\Point;
use PHPUnit\Framework\TestCase;

final class GeoHelperTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetBounds(): void
    {
        $points = $this->providePoints();

        $expectedBounds = [[-52.525442, -92.173776,], [83.282911, 74.810241,],];
        $actualBounds = GeoHelper::getBounds($points);

        $this->assertNotEmpty($actualBounds);
        $this->assertIsArray($actualBounds);
        $this->assertEquals($expectedBounds, $actualBounds);
    }

    /**
     * @return array<Point>
     */
    protected function providePoints(): array
    {
        $a = new Point(Point::WAYPOINT);
        $a->lat = -80.688897;
        $a->lon = -52.525442;

        $b = new Point(Point::WAYPOINT);
        $b->lat = -92.173776;
        $b->lon = 71.977676;

        $c = new Point(Point::WAYPOINT);
        $c->lat = 74.810241;
        $c->lon = 83.282911;

        $d = new Point(Point::WAYPOINT);
        $d->lat = 52.804218;
        $d->lon = 29.330932;

        return [$a, $b, $c, $d,];
    }
}
