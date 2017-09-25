<?php

namespace Gmi\PhpTests\Tests\ctype;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\Tests\ExtensionChecker;

class CtypeTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['ctype']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    /**
     * @group php_base
     */
    public function testCtypeAlnum()
    {
        $testString1 = 'AbC23d1zyZ945';
        $this->assertTrue(ctype_alnum($testString1));

        $testString2 = 'foo!#bar4';
        $this->assertFalse(ctype_alnum($testString2));
    }

    /**
     * @group php_base
     */
    public function testCtypeAlpha()
    {
        $testString1 = 'Letters123';
        $this->assertFalse(ctype_alpha($testString1));

        $testString2 = 'Letters';
        $this->assertTrue(ctype_alpha($testString2));
    }

    /**
     * @group php_base
     */
    public function testCtypeDigit()
    {
        $numeric1 = '3046';
        $this->assertTrue(ctype_digit($numeric1));

        $numeric2 = '25482.24';
        $this->assertFalse(ctype_digit($numeric2));

        $numeric3 = 'number';
        $this->assertFalse(ctype_digit($numeric3));
    }

    /**
     * @group php_base
     */
    public function testCtypeUpper()
    {
        $upperCaseCharacters1 = 'DONGIOVANNI';
        $this->assertTrue(ctype_upper($upperCaseCharacters1));

        $upperCaseCharacters2 = 'DonGiovanni';
        $this->assertFalse(ctype_upper($upperCaseCharacters2));
    }
}
