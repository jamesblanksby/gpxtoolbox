<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Types\Person;
use DOMDocument;
use DOMNode;
use SimpleXMLElement;

class PersonParser
{
    /**
     * Parses person data.
     * @param SimpleXMLElement $node
     * @return Person
     */
    public static function parse(SimpleXMLElement $node): Person
    {
        $person = new Person();

        if (isset($node->name)) {
            $person->name = (string) $node->name;
        }
        if (isset($node->email)) {
            $person->email = EmailParser::parse($node->email);
        }
        if (isset($node->link)) {
            $person->link = LinkParser::parse($node->link)[0];
        }

        return $person;
    }

    /**
     * XML representation of person data.
     * @param Person $person
     * @param DOMDocument $doc
     * @return DOMNode
     */
    public static function toXML(Person $person, DOMDocument $doc): DOMNode
    {
        $node = $doc->createElement('author');

        if (!empty($person->name)) {
            $child = $doc->createElement('name', $person->name);
            $node->appendChild($child);
        }

        if (!empty($person->email)) {
            $child = EmailParser::toXML($person->email, $doc);
            $node->appendChild($child);
        }

        if (!empty($person->link)) {
            $child = LinkParser::toXML($person->link, $doc);
            $node->appendChild($child);
        }

        return $node;
    }
}
