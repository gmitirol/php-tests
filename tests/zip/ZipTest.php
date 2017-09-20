<?php

namespace Gmi\PhpTests\Tests\zip;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\Tests\ExtensionChecker;

class ZipTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['zip']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    /**
     * @group php_base
     */
    public function testZipFunctions()
    {
        $zip = zip_open(__DIR__ . '/Fixtures/test.zip');
        $zipEntry = zip_read($zip);
        $this->assertSame('Hello Innsbruck!', zip_entry_read($zipEntry));
        zip_entry_close($zipEntry);
        zip_close($zip);
    }
}
