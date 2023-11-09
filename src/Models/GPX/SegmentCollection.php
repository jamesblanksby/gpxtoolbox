<?php

namespace GPXToolbox\Models\GPX;

use GPXToolbox\Traits\GPX\HasSplits;
use GPXToolbox\Traits\GPX\HasStatistics;

class SegmentCollection extends PointCollection
{
    use HasSplits;
    use HasStatistics;
}
