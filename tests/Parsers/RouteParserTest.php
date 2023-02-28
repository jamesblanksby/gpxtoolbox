<?php

namespace GPXToolbox\Tests\Parsers;

use GPXToolbox\Parsers\RouteParser;
use GPXToolbox\Types\Route;
use DOMDocument;
use DOMNode;

final class RouteParserTest extends ParserTestAbstract
{
    /**
     * @inheritDoc
     */
    protected $testParserClass = RouteParser::class;

    /**
     * @var Route
     */
    protected $testInstance;

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->testInstance = $this->createTestInstance();
    }

    /**
     * @return void
     */
    public function testParse(): void
    {
        $routes = RouteParser::parse($this->testXml->rte);

        $this->assertNotEmpty($routes);
        $this->assertIsArray($routes);

        $route = $routes[0];

        $this->assertEquals($this->testInstance, $route);
    }

    /**
     * @return Route
     */
    protected function createTestInstance(): Route
    {
        $route = new Route();

        $route->name = 'Route Test';
        $route->desc = 'A fictional test route';

        return $route;
    }

    /**
     * @param DOMDocument $doc
     * @return DOMNode
     */
    protected function convertToXML(DOMDocument $doc): DOMNode
    {
        return RouteParser::toXML($this->testInstance, $doc);
    }
}
