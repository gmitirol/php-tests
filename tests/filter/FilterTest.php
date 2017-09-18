<?php

namespace Gmi\PhpTests\Tests\filter;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\Tests\ExtensionChecker;

class FilterTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['filter']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    /**
     * Validating valid, invalid email address and integers.
     *
     * @group php_base
     */
    public function testFilterVar()
    {
        // Invalid email.
        $email1 = 'joe.hackerman';
        $this->assertFalse(filter_var($email1, FILTER_VALIDATE_EMAIL));

        // Valid email.
        $email2 = 'joe.hackerman@gmail.com';
        $this->assertSame('joe.hackerman@gmail.com', filter_var($email2, FILTER_VALIDATE_EMAIL));

        // Valid int.
        $integer1 = '25';
        $this->assertSame(25, filter_var($integer1, FILTER_VALIDATE_INT));

        // Invalid int.
        $integer2 = 'nikola';
        $this->assertFalse(filter_var($integer2, FILTER_VALIDATE_INT));
    }
}
