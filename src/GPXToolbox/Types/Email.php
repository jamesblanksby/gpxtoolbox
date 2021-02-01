<?php

namespace GPXToolbox\Types;

class Email
{
    /**
     * ID half of email address.
     * @var string
     */
    public $id = '';

    /**
     * Domain half of email address.
     * @var string
     */
    public $domain = '';

    /**
     * Array representation of email data.
     * @return array
     */
    public function toArray() : array
    {
        return [
            'id'     => $this->id,
            'domain' => $this->domain,
        ];
    }
}
