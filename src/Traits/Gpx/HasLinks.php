<?php

namespace GPXToolbox\Traits\Gpx;

use GPXToolbox\Models\Gpx\Link;
use GPXToolbox\Models\Gpx\LinkCollection;

trait HasLinks
{
    /**
     * Set links for the model.
     *
     * @param LinkCollection $links
     * @return $this
     */
    public function setLinks(LinkCollection $links)
    {
        $this->getLinks()->clear()->fill($links);

        return $this;
    }

    /**
     * Add a link to the model.
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
     * Get the links collection.
     *
     * @return LinkCollection
     */
    public function getLinks(): LinkCollection
    {
        return $this->link;
    }
}
