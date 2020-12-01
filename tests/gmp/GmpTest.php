<?php

namespace Gmi\PhpTests\Tests\gmp;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\ExtensionChecker;

class GmpTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['gmp']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    /**
     * @group php_base
     */
    public function testGmpAddAndGmpStrVal()
    {
        $sum = gmp_add('12345678901234567890', '765432109876543210');
        $result = '13111111011111111100';
        $this->assertSame($result, gmp_strval($sum));
    }

    /**
     * @group php_base
     */
    public function testGmpClrbit()
    {
        $num = gmp_init('0xef');
        gmp_clrbit($num, 0); // index starts at 0, least significant bit
        $this->assertSame('238', (gmp_strval($num)));
    }

    /**
     * @group php_base
     */
    public function testGmpDivQ()
    {
        $num = gmp_div_q('4686532906', '14');
        $result = '334752350';
        $this->assertSame($result, gmp_strval($num));
    }

    /**
     * @group php_base
     */
    public function testGmpPow()
    {
        $num = gmp_pow('3', 35);
        $result = '50031545098999707';
        $this->assertSame($result, (gmp_strval($num)));
    }
}
