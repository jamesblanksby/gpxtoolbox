<?php

namespace GPXToolbox\Types;

use GPXToolbox\Helpers\SerializationHelper;

class Person
{
    /**
     * Name of person or organization.
     * @var string|null
     */
    public $name = null;

    /**
     * Email address.
     * @var Email|null
     */
    public $email = null;

    /**
     * Link to Web site or other external information about person.
     * @var Link|null
     */
    public $link = null;

    /**
     * Array representation of person data.
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name'  => $this->name,
            'email' => SerializationHelper::toArray($this->email),
            'link'  => SerializationHelper::toArray($this->link),
        ];
    }
}
