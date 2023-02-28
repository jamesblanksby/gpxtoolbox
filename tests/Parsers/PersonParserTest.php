<?php

namespace GPXToolbox\Tests\Parsers;

use GPXToolbox\Parsers\PersonParser;
use GPXToolbox\Types\Email;
use GPXToolbox\Types\Link;
use GPXToolbox\Types\Person;
use DOMDocument;
use DOMNode;

final class PersonParserTest extends ParserTestAbstract
{
    /**
     * @inheritDoc
     */
    protected $testParserClass = PersonParser::class;

    /**
     * @var Person
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
        $person = PersonParser::parse($this->testXml->author);

        $this->assertNotEmpty($person);
        $this->assertEquals($this->testInstance, $person);
    }

    /**
     * @return Person
     */
    protected function createTestInstance(): Person
    {
        $person = new Person();

        $person->name = 'John Doe';
        $person->email = new Email();
        $person->email->id = 'john.doe';
        $person->email->domain = 'example.com';
        $person->link = new Link();
        $person->link->href = 'https://www.example.com/';
        $person->link->text = 'example.com';
        $person->link->type = 'text/html';

        return $person;
    }

    /**
     * @param DOMDocument $doc
     * @return DOMNode
     */
    protected function convertToXML(DOMDocument $doc): DOMNode
    {
        return PersonParser::toXML($this->testInstance, $doc);
    }
}
