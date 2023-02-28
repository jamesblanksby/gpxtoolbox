<?php

namespace GPXToolbox\Tests\Helpers;

use GPXToolbox\Helpers\SerializationHelper;
use PHPUnit\Framework\TestCase;

final class SerializationHelperTest extends TestCase
{
    /**
     * @return void
     */
    public function testfilterNotNull(): void
    {
        $testData = [
            '',
            'not empty',
            null,
            array(),
            array(array()),
            array(array('not empty')),
            array(array(),array('not empty'),array(array())),
            true,
            false,
            '1',
            '0',
            1,
            0,
        ];

        $expectedData = [
            0 => '',
            1 => 'not empty',
            5 => array(array('not empty')),
            6 => array(1 => array('not empty')),
            7 => true,
            8 => false,
            9 => '1',
            10 => '0',
            11 => 1,
            12 => 0,
        ];
        $actualData = SerializationHelper::filterNotNull($testData);

        $this->assertEquals($expectedData, $actualData);
    }
}
