<?php

namespace Gmi\PhpTests\Tests\zlib;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\ExtensionChecker;

class ZlibTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['zlib']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    /**
     * @group php_base
     */
    public function testGzFunctions()
    {
        $fp = gzopen(__DIR__ . '/Fixtures/test.gz', 'r');
        $this->assertNotFalse($fp);
        $contents = gzread($fp, 10000);
        $this->assertSame('Hello World!', $contents);
        $this->assertTrue(gzclose($fp));
    }
}
