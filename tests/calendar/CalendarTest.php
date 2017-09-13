<?php

namespace Gmi\PhpTests\Tests\calendar;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\Tests\ExtensionChecker;

class CalendarTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['calendar']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    public function testCalDaysInMonth()
    {
        // Asserting that month July in 1996. had 31 days by Gregorian calendar.
        $this->assertSame(31, cal_days_in_month(CAL_GREGORIAN, 7, 1996));
    }

    /**
     * Checking calendar info to find out which Calendar year is valid one.
     */
    public function testCalInfo()
    {
        $this->assertSame('Gregorian', cal_info(0)['calname']);

        $this->assertSame('Jewish', cal_info(2)['calname']);
    }

    public function testEasterDate()
    {
        $this->assertSame('2017-04-16', date('Y-m-d', easter_date(2017)));
    }
}
