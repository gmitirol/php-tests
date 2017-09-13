<?php

namespace Gmi\PhpTests\Tests\fileinfo;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\Tests\ExtensionChecker;

class FileinfoTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['fileinfo']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    /**
     * Checking type of content from 2 different files.
     */
    public function testMimeContentType()
    {
        $filename1 = __DIR__ . '/Fixtures/example.txt';
        $result1 = mime_content_type($filename1);
        $this->assertSame('text/plain', $result1);

        $filename2 = __DIR__ . '/Fixtures/mountain.jpg';
        $result2 = mime_content_type($filename2);
        $this->assertSame('image/jpeg', $result2);
    }
}
