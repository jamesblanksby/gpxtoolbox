<?php

namespace GPXToolbox\Tests\Parsers;

use GPXToolbox\Parsers\MetadataParser;
use GPXToolbox\Types\Metadata;
use DateTime;
use DOMDocument;
use DOMNode;

final class MetadataParserTest extends ParserTestAbstract
{
    /**
     * @inheritDoc
     */
    protected $testParserClass = MetadataParser::class;

    /**
     * @var Metadata
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
        $metadata = MetadataParser::parse($this->testXml->metadata);

        $this->assertNotEmpty($metadata);

        $this->assertEquals($this->testInstance, $metadata);
    }

    /**
     * @return Metadata
     */
    protected function createTestInstance(): Metadata
    {
        $metadata = new Metadata();

        $metadata->name = 'GPXToolbox Test';
        $metadata->desc = 'A GPX file used in development unit tests';
        $metadata->time = new DateTime('2004-08-09 10:30:00');
        $metadata->keywords = 'GPXToolbox, GPX, Test';

        return $metadata;
    }

    /**
     * @param DOMDocument $doc
     * @return DOMNode
     */
    protected function convertToXML(DOMDocument $doc): DOMNode
    {
        return MetadataParser::toXML($this->testInstance, $doc);
    }
}
