<?php

namespace Gmi\PhpTests\Tests\iconv;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\ExtensionChecker;

class IconvTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['iconv']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    /**
     * Returns the current value of the internal configuration variable if successful or FALSE on failure.
     *
     * @See http://php.net/manual/en/function.iconv-get-encoding.php
     *
     * @group php_base
     */
    public function testIconvSetGetEncoding()
    {
        $utf8 = @iconv_set_encoding('internal_encoding', 'UTF-8');
        $this->assertSame(true, $utf8);
        $this->assertSame('UTF-8', @iconv_get_encoding('internal_encoding'));

        $iso = @iconv_set_encoding('output_encoding', 'ISO-8859-1');
        $this->assertSame(true, $iso);
        $this->assertSame('ISO-8859-1', @iconv_get_encoding('output_encoding'));
    }

    /**
     * @group php_base
     */
    public function testIconvTranslit()
    {
        $utf8example = 'Weiß, Göbel, Weiss, Göthe, und Zižić. Followed by Žluťoućký kůň';
        // Converting 'UTF-8' to 'ASCII'
        $converted = iconv('UTF-8', 'ASCII//TRANSLIT', $utf8example);
        $this->assertSame('Weiss, Gobel, Weiss, Gothe, und Zizic. Followed by Zlutoucky kun', $converted);
    }

    /**
     * @group php_base
     */
    public function testIconvIgnore()
    {
        $utf8example = 'Weiß, Göbel, Weiss, Göthe, und Zižić. Followed by Žluťoućký kůň';
        // Converting 'UTF-8' to 'ASCII'
        $converted = iconv('UTF-8', 'ASCII//IGNORE', $utf8example);
        $this->assertSame('Wei, Gbel, Weiss, Gthe, und Zii. Followed by luouk k', $converted);
    }

    /**
     * @group php_base
     */
    public function testIconvEmpty()
    {
        if (!extension_loaded('mbstring')) {
            $this->markTestSkipped('mb_convert_encoding not available!');
        }

        $utf8example = 'Weiß, Göbel, Weiss, Göthe';
        // Converting 'UTF-8' to 'windows-1252'
        $converted = iconv('UTF-8', 'windows-1252', $utf8example);

        $this->assertSame(mb_convert_encoding($utf8example, 'windows-1252', 'UTF-8'), $converted);
    }
}

