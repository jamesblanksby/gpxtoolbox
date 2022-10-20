<?php

namespace GPXToolbox\Parsers;

use GPXToolbox\Types\Email;
use SimpleXMLElement;
use DOMDocument;
use DOMNode;

class EmailParser
{
    /**
     * Parses email data.
     * @param SimpleXMLElement $node
     * @return Email
     */
    public static function parse(SimpleXMLElement $node): Email
    {
        $email = new Email();

        $email->id     = isset($node['id']) ? (string) $node['id'] : null;
        $email->domain = isset($node['domain']) ? (string) $node['domain'] : null;

        return $email;
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

        if (!empty($email->id)) {
            $node->setAttribute('id', $email->id);
        }

        if (!empty($email->domain)) {
            $node->setAttribute('domain', $email->domain);
        }

        return $node;
    }
}
