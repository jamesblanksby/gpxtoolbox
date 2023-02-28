<?php

namespace GPXToolbox\Tests\Parsers;

use GPXToolbox\Parsers\TrackParser;
use GPXToolbox\Types\Track;
use DOMDocument;
use DOMNode;

final class TrackParserTest extends ParserTestAbstract
{
    /**
     * @inheritDoc
     */
    protected $testParserClass = TrackParser::class;

    /**
     * @var Track
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
        $tracks = TrackParser::parse($this->testXml->trk);

        $this->assertNotEmpty($tracks);
        $this->assertIsArray($tracks);

        $track = $tracks[0];

        $this->assertEquals($this->testInstance, $track);
    }

    /**
     * @return Track
     */
    protected function createTestInstance(): Track
    {
        $track = new Track();

        $track->name = 'Track Test';
        $track->desc = 'A fictional test track';

        return $track;
    }

    /**
     * @param DOMDocument $doc
     * @return DOMNode
     */
    protected function convertToXML(DOMDocument $doc): DOMNode
    {
        return TrackParser::toXML($this->testInstance, $doc);
    }
}
