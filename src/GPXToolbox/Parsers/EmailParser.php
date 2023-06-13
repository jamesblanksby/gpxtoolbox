<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Types\Email;
use SimpleXMLElement;
use DOMDocument;
use DOMNode;

class EmailParser
{
    /**
     * @var array<mixed>
     */
    private static $map = [
        'id' => [
            'name' => 'id',
            'type' => 'attribute',
            'parser' => 'string',
        ],
        'domain' => [
            'name' => 'domain',
            'type' => 'attribute',
            'parser' => 'string',
        ],
    ];

    /**
     * Parses email data.
     * @param SimpleXMLElement $node
     * @return Email
     */
    public static function parse(SimpleXMLElement $node): Email
    {
        return XMLElementParser::parse($node, new Email(), self::$map);
    }

    /**
     * XML representation of email data.
     * @param Email $email
     * @param DOMDocument $doc
     * @return DOMNode
     */
    public static function toXML(Email $email, DOMDocument $doc): DOMNode
    {
        $node = $doc->createElement('email');

        if ($email->id) {
            $node->setAttribute('id', $email->id);
        }

        if ($email->domain) {
            $node->setAttribute('domain', $email->domain);
        }

        return $node;
    }
}
