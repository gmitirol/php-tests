<?php

namespace Gmi\PhpTests\Tests\imagick;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\Tests\ExtensionChecker;

use Imagick;

class ImagickTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['imagick']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    public function testGetNumberImages()
    {
        $document = new Imagick(__DIR__ . '/Fixtures/my.pdf');
        $this->assertSame(3, $document->getNumberImages());
    }

    public function testGetFilenamePdf()
    {
        $document = new Imagick(__DIR__ . '/Fixtures/my.pdf');
        $name = $document->getImageFilename();
        $this->assertSame('my.pdf', pathinfo($name, PATHINFO_BASENAME));
    }

    public function testGetFilenameJpg()
    {
        $document = new Imagick(__DIR__ . '/Fixtures/moon.jpg');
        $name = $document->getImageFilename();
        $this->assertSame('moon.jpg', pathinfo($name, PATHINFO_BASENAME));
    }

    public function testGetImageGeometry()
    {
        $img = new Imagick(__DIR__ . '/Fixtures/moon.jpg');
        $geo = $img->getImageGeometry();
        $this->assertSame(1680, $geo['width']);
        $this->assertSame(1050, $geo['height']);
    }

    public function testGetImageFormat()
    {
        $img = new Imagick(__DIR__ . '/Fixtures/moon.jpg');
        $this->assertSame('JPEG', $img->getImageFormat());
    }

    public function testResizeImage()
    {
        $img = new Imagick(__DIR__ . '/Fixtures/moon.jpg');
        $img->resizeImage(400, 260, Imagick::FILTER_LANCZOS, 1);
        $this->assertSame(400, $img->getImageWidth());
        $this->assertSame(260, $img->getImageHeight());
    }

    /**
     * Checking size of image, represented in bytes.
     */
    public function testGetImageLength()
    {
        $img = new Imagick(__DIR__ . '/Fixtures/moon.jpg');
        $this->assertSame(116787, $img->getImageLength());
    }

    public function testGetImageProperties()
    {
        $document = new Imagick(__DIR__ . '/Fixtures/my.pdf');
        $this->assertArrayHasKey('pdf:Version', $document->getImageProperties());
    }
}
