<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Types\Person;
use DOMDocument;
use DOMNode;
use SimpleXMLElement;

class PersonParser
{
    /**
     * @var array<mixed>
     */
    private static $map = [
        'name' => [
            'name' => 'name',
            'type' => 'element',
            'parser' => 'string',
        ],
        'email' => [
            'name' => 'email',
            'type' => 'element',
            'parser' => EmailParser::class,
        ],
        'link' => [
            'name' => 'link',
            'type' => 'element',
            'parser' => LinkParser::class,
        ],
    ];

    /**
     * Parses person data.
     * @param SimpleXMLElement $node
     * @return Person
     */
    public static function parse(SimpleXMLElement $node): Person
    {
        $person = XMLElementParser::parse($node, new Person(), self::$map);
        $person->link = reset($person->link);

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

        if ($person->name) {
            $child = $doc->createElement('name', $person->name);
            $node->appendChild($child);
        }

        if ($person->email) {
            $child = EmailParser::toXML($person->email, $doc);
            $node->appendChild($child);
        }

        if ($person->link) {
            $child = LinkParser::toXML($person->link, $doc);
            $node->appendChild($child);
        }

        return $node;
    }
}
