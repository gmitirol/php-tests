<?php

namespace Gmi\PhpTests\Tests\gd;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\Tests\ExtensionChecker;

class GdTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['gd']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    /**
     * @group php_base
     */
    public function testGetImageSizeFromString()
    {
        $mypicture = __DIR__ . '/Fixtures/moon.jpg';
        $size = getimagesize($mypicture);
        // Asserting that image has 8 bit color depth per channel.
        $this->assertSame(8, $size['bits']);
    }

    /**
     * @group php_base
     */
    public function testImageScale()
    {
        $image =  imagecreatefromjpeg(__DIR__ . '/Fixtures/moon.jpg');
        $imageScale = imagescale($image, 100);
        // Return true if it is successful, or false if it is not.
        $new = imagejpeg($imageScale, __DIR__ . '/new.jpg', 90);
        $this->assertTrue($new);

        $imageSize = getimagesize(__DIR__ . '/new.jpg');
        // Asserting that new width is 100, as it is set before.
        $this->assertSame(100, $imageSize[0]);
        // Assert that picture is in jpeg format.
        $this->assertSame('image/jpeg', $imageSize['mime']);
        imagedestroy($image);

        @unlink(__DIR__ . '/new.jpg');
    }
}
