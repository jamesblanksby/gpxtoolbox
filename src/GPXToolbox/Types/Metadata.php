<?php

namespace GPXToolbox\Types;

use GPXToolbox\Helpers\DateTimeHelper;
use GPXToolbox\Helpers\SerializationHelper;
use GPXToolbox\Interfaces\ArraySerializableInterface;
use GPXToolbox\Types\Extensions\ExtensionAbstract;
use DateTime;

class Metadata implements ArraySerializableInterface
{
    /**
     * The name of the GPX file.
     * @var string|null
     */
    public $name = null;

    /**
     * A description of the contents of the GPX file.
     * @var string|null
     */
    public $desc = null;

    /**
     * The person or organization who created the GPX file.
     * @var Person|null
     */
    public $author = null;

    /**
     * Copyright and license information governing use of the file.
     * @var Copyright|null
     */
    public $copyright = null;

    /**
     * URLs associated with the location described in the file.
     * @var array<Link>
     */
    public $links = [];

    /**
     * The creation date of the file.
     * @var DateTime|null
     */
    public $time = null;

    /**
     * Keywords associated with the file.
     * Search engines or databases can use this information to classify the data.
     * @var string|null
     */
    public $keywords = null;

    /**
     * Minimum and maximum coordinates which
     * describe the extent of the coordinates in the file.
     * @var Bounds|null
     */
    public $bounds = null;

    /**
     * A list of extensions.
     * @var array<ExtensionAbstract>
     */
    public $extensions = [];

    /**
     * Add link to metadata.
     * @param Link $link
     * @return self
    */
    public function addLink(Link $link): self
    {
        array_push($this->links, $link);

        return $this;
    }

    /**
     * Add extension to metadata.
     * @param ExtensionAbstract $extension
     * @return self
    */
    public function addExtension(ExtensionAbstract $extension): self
    {
        array_push($this->extensions, $extension);

        return $this;
    }

    /**
     * Array representation of metadata.
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return SerializationHelper::filterNotNull([
            'name'       => $this->name,
            'desc'       => $this->desc,
            'author'     => SerializationHelper::toArray($this->author),
            'copyright'  => SerializationHelper::toArray($this->copyright),
            'link'       => SerializationHelper::toArray($this->links),
            'time'       => DateTimeHelper::format($this->time),
            'keywords'   => $this->keywords,
            'bounds'     => SerializationHelper::toArray($this->bounds),
            'extensions' => SerializationHelper::toArray($this->extensions),
        ]);
    }
}
