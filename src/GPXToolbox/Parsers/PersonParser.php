<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Types\Person;

class PersonParser
{
    /**
     * Parses person data.
     * @param \SimpleXMLElement $node
     * @return Person
     */
    public static function parse(\SimpleXMLElement $node): Person
    {
        $person = new Person();

        $person->name  = isset($node->name) ? (string) $node->name : null;
        $person->email = isset($node->email) ? EmailParser::parse($node->email) : null;
        $person->link  = isset($node->link) ? LinkParser::parse($node->link)[0] : null;

        return $person;
    }

    /**
     * XML representation of person data.
     * @param Person $person
     * @param \DOMDocument $doc
     * @return \DOMNode
     */
    public static function toXML(Person $person, \DOMDocument $doc): \DOMNode
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
