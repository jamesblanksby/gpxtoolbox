<?php

namespace GPXToolbox\Tests\Parsers;

use GPXToolbox\Parsers\EmailParser;
use GPXToolbox\Types\Email;
use DOMDocument;
use DOMNode;

final class EmailParserTest extends ParserTestAbstract
{
    /**
     * @inheritDoc
     */
    protected $testParserClass = EmailParser::class;

    /**
     * @var Email
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
        $email = EmailParser::parse($this->testXml->email);

        $this->assertNotEmpty($email);
        $this->assertEquals($this->testInstance, $email);
    }

    /**
     * @return Email
     */
    protected function createTestInstance(): Email
    {
        $email = new Email();

        $email->id = 'john.doe';
        $email->domain = 'example.com';

        return $email;
    }

    /**
     * @param DOMDocument $doc
     * @return DOMNode
     */
    protected function convertToXML(DOMDocument $doc): DOMNode
    {
        return EmailParser::toXML($this->testInstance, $doc);
    }
}
