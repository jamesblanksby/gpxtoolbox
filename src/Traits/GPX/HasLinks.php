<?php

namespace GPXToolbox\Traits\Gpx;

use GPXToolbox\Models\Gpx\Link;
use GPXToolbox\Models\Gpx\LinkCollection;

trait HasLinks
{
    public function setLinks(LinkCollection $links)
    {
        $this->getLinks()->clear()->fill($links);

        return $this;
    }

    public function addLink(Link $link)
    {
        $this->getLinks()->add($link);

        return $this;
    }

    public function getLinks(): LinkCollection
    {
        return $this->link;
    }
}
