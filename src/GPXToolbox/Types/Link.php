<?php

namespace GPXToolbox\Types;

use GPXToolbox\Helpers\SerializationHelper;
use GPXToolbox\Interfaces\ArraySerializableInterface;

class Link implements ArraySerializableInterface
{
    /**
     * URL of hyperlink.
     * @var string
     */
    public $href = '';

    /**
     * Text of hyperlink.
     * @var string|null
     */
    public $text = null;

    /**
     * Mime type of content.
     * @var string|null
     */
    public $type = null;

    /**
     * Array representation of link data.
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return SerializationHelper::filterNotNull([
            'href' => $this->href,
            'text' => $this->text,
            'type' => $this->type,
        ]);
    }
}
