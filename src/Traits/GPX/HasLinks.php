<?php

namespace GPXToolbox\Traits\GPX;

use GPXToolbox\Models\GPX\Link;
use GPXToolbox\Models\GPX\LinkCollection;

trait HasLinks
{
    /**
     * Set a list of links associated with the collection.
     *
     * @param LinkCollection $links
     * @return $this
     */
    public function setLinks(LinkCollection $links)
    {
        $this->getLinks()->fill($links);

        return $this;
    }

    /**
     * Add a link to the associated links collection.
     *
     * @param Link $link
     * @return $this
     */
    public function addLink(Link $link)
    {
        $this->getLinks()->add($link);

        return $this;
    }

    /**
     * Get a list of links associated with the split.
     *
     * @return LinkCollection
     */
    public function getLinks(): LinkCollection
    {
        return $this->link;
    }
}
