<?php

namespace Gmi\PhpTests\Tests\readline;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\ExtensionChecker;

class ReadlineTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['readline']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    /**
     * readline_list_history() - is only available when PHP is compiled with libreadline.
     *
     * @group php_base
     */
    public function testReadlineHistory()
    {
        $this->assertTrue(readline_add_history('Example'));
        $this->assertTrue(readline_clear_history());
    }

    /**
     * @group php_base
     */
    public function testReadlineInfo()
    {
        $result = readline_info();
        $this->assertNotEmpty($result);
        $this->assertArrayHasKey('library_version', $result);
    }
}
