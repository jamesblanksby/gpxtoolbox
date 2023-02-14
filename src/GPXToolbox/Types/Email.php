<?php

namespace GPXToolbox\Types;

use GPXToolbox\Helpers\SerializationHelper;
use GPXToolbox\Interfaces\ArraySerializableInterface;

class Email implements ArraySerializableInterface
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
     * @return mixed[]
     */
    public function toArray(): array
    {
        return SerializationHelper::filterEmpty([
            'id'     => $this->id,
            'domain' => $this->domain,
        ]);
    }
}
