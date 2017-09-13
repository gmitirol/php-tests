<?php

namespace Gmi\PhpTests\Tests\bz2;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\Tests\ExtensionChecker;

class Bz2Test extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['bz2']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    public function testBz2()
    {
        $filename = __DIR__ . 'example.bz2';
        $sampletext = 'This is a test string.';

        // open file for writing
        $bz = bzopen($filename, 'w');

        // write string to file
        bzwrite($bz, $sampletext);

        // close file
        bzclose($bz);

        // open file for reading
        $bz = bzopen($filename, 'r');

        // output until end of the file (or the next 1024 char) and close it.
        $result = bzread($bz);
        $this->assertSame('This is a test string.', $result);

        $this->assertTrue(bzclose($bz));
    }
}
