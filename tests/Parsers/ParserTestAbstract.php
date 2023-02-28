<?php

namespace GPXToolbox\Tests\Parsers;

use PHPUnit\Framework\TestCase;
use DOMDocument;
use DOMNode;
use ReflectionClass;
use SimpleXMLElement;

abstract class ParserTestAbstract extends TestCase
{
    /**
     * @var class-string
     */
    protected $testParserClass;

    /**
     * @var SimpleXMLElement
     */
    protected $testXml;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $reflection = new ReflectionClass($this->testParserClass);

        $filename = sprintf('%s/data/%sTest.xml', __DIR__, $reflection->getShortName());
        $xml = simplexml_load_file($filename);

        if ($xml) {
            $this->testXml = $xml;
        }
    }

    /**
     * @return void
     */
    public function testToXML(): void
    {
        $doc = new DOMDocument('1.0', 'utf-8');
        $gpx = $doc->createElement('gpx');

        $nodes = $this->convertToXML($doc);
        if (!is_array($nodes)) {
            $nodes = [$nodes,];
        }

        foreach ($nodes as $node) {
            $gpx->appendChild($node);
        }

        $doc->appendChild($gpx);

        $expectedXML = $this->testXml->asXML();
        $actualXML = $doc->saveXML();

        if ($expectedXML && $actualXML) {
            $this->assertXmlStringEqualsXmlString($expectedXML, $actualXML);
        }
    }

    /**
     * @param DOMDocument $document
     * @return DOMNode|DOMNode[]
     */
    abstract protected function convertToXML(DOMDocument $document): mixed;
}
