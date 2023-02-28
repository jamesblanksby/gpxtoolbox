<?php

namespace GPXToolbox\Tests\Parsers;

use GPXToolbox\Parsers\BoundsParser;
use GPXToolbox\Types\Bounds;
use DOMDocument;
use DOMNode;

final class BoundsParserTest extends ParserTestAbstract
{
    /**
     * @inheritDoc
     */
    protected $testParserClass = BoundsParser::class;

    /**
     * @var Bounds
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
        $bounds = BoundsParser::parse($this->testXml->bounds);

        $this->assertNotEmpty($bounds);
        $this->assertEquals($this->testInstance, $bounds);
    }

    /**
     * @return Bounds
     */
    protected function createTestInstance(): Bounds
    {
        $bounds = new Bounds();

        $bounds->minlat = -90.0;
        $bounds->minlon = -180.0;
        $bounds->maxlat = 90.0;
        $bounds->maxlon = 180.0;

        return $bounds;
    }

    /**
     * @param DOMDocument $doc
     * @return DOMNode
     */
    protected function convertToXML(DOMDocument $doc): DOMNode
    {
        return BoundsParser::toXML($this->testInstance, $doc);
    }
}
