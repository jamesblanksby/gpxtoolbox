<?php

namespace GPXToolbox\Tests\Parsers;

use GPXToolbox\Parsers\LinkParser;
use GPXToolbox\Types\Link;
use DOMDocument;
use DOMNode;

final class LinkParserTest extends ParserTestAbstract
{
    /**
     * @inheritDoc
     */
    protected $testParserClass = LinkParser::class;

    /**
     * @var Link
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
        $links = LinkParser::parse($this->testXml->link);

        $this->assertNotEmpty($links);
        $this->assertIsArray($links);

        $link = $links[0];

        $this->assertEquals($this->testInstance, $link);
    }

    /**
     * @return Link
     */
    protected function createTestInstance(): Link
    {
        $link = new Link();

        $link->href = 'https://www.example.com/';
        $link->text = 'example.com';
        $link->type = 'text/html';

        return $link;
    }

    /**
     * @param DOMDocument $doc
     * @return DOMNode
     */
    protected function convertToXML(DOMDocument $doc): DOMNode
    {
        return LinkParser::toXML($this->testInstance, $doc);
    }
}
