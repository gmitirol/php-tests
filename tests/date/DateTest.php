<?php

namespace Gmi\PhpTests\Tests\date;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\Tests\ExtensionChecker;

use DateTime;

class DateTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['date']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    /**
     * @group php_base
     */
    public function testCheckDateInvalid()
    {
        $this->assertSame(false, checkdate(2, 29, 2017));
    }

    /**
     * @group php_base
     */
    public function testCheckDateValid()
    {
        $this->assertSame(true, checkdate(1, 29, 2017));
    }

    /**
     * @group php_base
     */
    public function testDateCreateAndDateFormat()
    {
        $date = new DateTime('06/18/2016');
        $formattedDate = date_format($date, 'Y:m:d');
        $this->assertSame('2016:06:18', $formattedDate);
    }

    /**
     * This function returns FALSE if the timezone_identifier isn't valid, or TRUE otherwise.
     *
     * @group php_base
     */
    public function testDateDefaultTimezoneSet()
    {
        $zone = date_default_timezone_set('Europe/Vienna');
        $this->assertTrue($zone);
    }

    /**
     * @group php_base
     */
    public function testDateParse()
    {
        $inputDate = "March 2014";
        $info = date_parse($inputDate);
        $this->assertSame(2014, $info['year']);
    }
}
