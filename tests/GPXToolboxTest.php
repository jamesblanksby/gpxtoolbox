<?php

namespace GPXToolbox\Tests;

use GPXToolbox\GPXToolbox;
use PHPUnit\Framework\TestCase;
use RuntimeException;

final class GPXToolboxTest extends TestCase
{
    /**
     * @return void
     */
    public function testExistingFileLoad(): void
    {
        $toolbox = new GPXToolbox();
        $gpx = $toolbox::load(__DIR__ . '/data/TestExistingFileLoad.gpx');

        $this->assertIsArray($gpx->toArray());
    }

    /**
     * @return void
     */
    public function testMissingFileLoad(): void
    {
        $this->expectException(RuntimeException::class);

        $toolbox = new GPXToolbox();
        $toolbox::load(__DIR__ . '/data/TestMissingFileLoad.gpx');
    }

    /**
     * @return void
     */
    public function testInvalidXMLParse(): void
    {
        $this->expectException(RuntimeException::class);

        $toolbox = new GPXToolbox();
        $toolbox::load(__DIR__ . '/data/TestInvalidXMLParse.gpx');
    }
}
