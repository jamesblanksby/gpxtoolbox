<?php

namespace GPXToolbox\Tests\Helpers;

use GPXToolbox\Helpers\DateTimeHelper;
use PHPUnit\Framework\TestCase;
use DateTime;
use DateTimeInterface;

final class DateTimeHelperTest extends TestCase
{
    /**
     * @return void
     */
    public function testDateTimeFormat(): void
    {
        $datetime = new DateTime('2004-08-09T10:30:00+00:00');
        $format = DateTimeInterface::ATOM;

        $this->assertEquals($datetime->format($format), DateTimeHelper::format($datetime, $format));
    }

    /**
     * @return void
     */
    public function testDateTimeFormatWithTimezone(): void
    {
        $datetime = new DateTime('2004-08-09T10:30:00+00:00');
        $format = DateTimeInterface::ATOM;
        $timezone = '+02:00';

        $this->assertEquals('2004-08-09T12:30:00+02:00', DateTimeHelper::format($datetime, $format, $timezone));
    }

    /**
     * @return void
     */
    public function testNullDateTimeFormat(): void
    {
        $datetime = null;

        $this->assertNull(DateTimeHelper::format($datetime));
    }

    /**
     * @return void
     */
    public function testEmptyStringDateTimeFormat(): void
    {
        $datetime = '';

        $this->assertNull(DateTimeHelper::format($datetime));
    }
}