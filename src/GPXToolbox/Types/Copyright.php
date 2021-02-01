<?php

namespace GPXToolbox\Types;

class Copyright
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
     * @return array
     */
    public function toArray() : array
    {
        return [
            'author'  => $this->author,
            'year'    => $this->year,
            'license' => $this->license,
        ];
    }
}
