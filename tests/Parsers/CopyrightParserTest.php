<?php

namespace GPXToolbox\Tests\Parsers;

use GPXToolbox\Parsers\CopyrightParser;
use GPXToolbox\Types\Copyright;
use DOMDocument;
use DOMNode;

final class CopyrightParserTest extends ParserTestAbstract
{
    /**
     * @inheritDoc
     */
    protected $testParserClass = CopyrightParser::class;

    /**
     * @var Copyright
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
        $copyright = CopyrightParser::parse($this->testXml->copyright);

        $this->assertNotEmpty($copyright);
        $this->assertEquals($this->testInstance, $copyright);
    }

    /**
     * @return Copyright
     */
    protected function createTestInstance(): Copyright
    {
        $copyright = new Copyright();

        $copyright->author = 'John Doe';
        $copyright->year = '2004';
        $copyright->license = 'https://opensource.org/license/mit/';

        return $copyright;
    }

    /**
     * @param DOMDocument $doc
     * @return DOMNode
     */
    protected function convertToXML(DOMDocument $doc): DOMNode
    {
        return CopyrightParser::toXML($this->testInstance, $doc);
    }
}
