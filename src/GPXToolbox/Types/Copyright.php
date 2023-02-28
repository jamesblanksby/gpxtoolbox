<?php

namespace GPXToolbox\Types;

use GPXToolbox\Helpers\SerializationHelper;
use GPXToolbox\Interfaces\ArraySerializableInterface;

class Copyright implements ArraySerializableInterface
{
    /**
     * Copyright holder.
     * @var string
     */
    public $author = '';

    /**
     * Year of copyright.
     * @var string|null
     */
    public $year = null;

    /**
     * Link to external file containing license text.
     * @var string|null
     */
    public $license = null;

    /**
     * Array representation of copyright data.
     * @return mixed[]
     */
    public function toArray(): array
    {
        return SerializationHelper::filterNotNull([
            'author'  => $this->author,
            'year'    => $this->year,
            'license' => $this->license,
        ]);
    }
}
