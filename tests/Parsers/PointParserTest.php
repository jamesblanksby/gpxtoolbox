<?php

namespace GPXToolbox\Tests\Parsers;

use GPXToolbox\GPXToolbox;
use GPXToolbox\Parsers\PointParser;
use GPXToolbox\Types\Point;
use DateTime;
use DOMDocument;
use DOMNode;

final class PointParserTest extends ParserTestAbstract
{
    /**
     * @inheritDoc
     */
    protected $testParserClass = PointParser::class;

    /**
     * @var array<Point>
     */
    protected $testInstances = [];

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        parent::setUp();

        $types = [
            'waypoint',
            'trackpoint',
            'routepoint',
        ];
        foreach ($types as $type) {
            $callback = [$this, sprintf('create%sTestInstance', ucfirst($type)),];
            if (is_callable($callback)) {
                $instance = call_user_func($callback);
                if ($instance instanceof Point) {
                    $this->testInstances []= $instance;
                }
            }
        }
    }

    /**
     * @return void
     */
    public function testParse(): void
    {
        GPXToolbox::$COORDINATE_PRECISION = 6;
        GPXToolbox::$ELEVATION_PRECISION = 2;

        $points = PointParser::parse($this->testXml);

        $this->assertNotEmpty($points);
        $this->assertIsArray($points);

        foreach ($points as $index => $point) {
            $this->assertEquals($this->testInstances[$index], $point);
        }
    }

    /**
     * @return Point
     */
    protected function createWaypointTestInstance(): Point
    {
        $point = new Point(Point::WAYPOINT);

        $point->lat = -80.688897;
        $point->lon = -52.525442;
        $point->ele = 29.39;
        $point->time = new DateTime('2004-08-09T10:10:30+00:00');

        return $point;
    }
    /**
     * @return Point
     */
    protected function createTrackpointTestInstance(): Point
    {
        $point = new Point(Point::TRACKPOINT);

        $point->lat = -55.704596;
        $point->lon = -32.528228;
        $point->ele = 48.62;
        $point->time = new DateTime('2004-08-09T10:20:00+00:00');

        return $point;
    }

    /**
     * @return Point
     */
    protected function createRoutepointTestInstance(): Point
    {
        $point = new Point(Point::ROUTEPOINT);

        $point->lat = -61.552498;
        $point->lon = 33.495067;
        $point->ele = 17.15;
        $point->time = new DateTime('2004-08-09T10:40:00+00:00');

        return $point;
    }

    /**
     * @param DOMDocument $doc
     * @return array<DOMNode>
     */
    protected function convertToXML(DOMDocument $doc): array
    {
        return PointParser::toXMLArray($this->testInstances, $doc);
    }
}
