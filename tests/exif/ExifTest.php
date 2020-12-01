<?php

namespace Gmi\PhpTests\Tests\exif;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\ExtensionChecker;

class ExifTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['exif']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    /**
     * @group php_base
     */
    public function testExifImagetype()
    {
        $picture1 = __DIR__ . '/Fixtures/1.png';
        $this->assertFalse(exif_imagetype($picture1) === IMAGETYPE_JPEG);
        $this->assertTrue(exif_imagetype($picture1) === IMAGETYPE_PNG);
    }
}
