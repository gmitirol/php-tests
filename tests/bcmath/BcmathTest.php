<?php

namespace Gmi\PhpTests\Tests\bcmath;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\ExtensionChecker;

class BcmathTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['bcmath']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    /**
     * @group php_base
     */
    public function testBcadd()
    {
        $firstNumber = '24823.234567';
        $secondNumber = '470001.599';
        $result1 = bcadd($firstNumber, $secondNumber);
        $this->assertSame('494824', $result1);

        $result2 = bcadd($firstNumber, $secondNumber, 5);
        $this->assertSame('494824.83356', $result2);
    }

    /**
     * @group php_base
     */
    public function testBccomp()
    {
        $firstNumber = '182111';
        $secondNumber = '25542';
        $result = bccomp($firstNumber, $secondNumber);
        $this->assertSame(1, $result);

        $thirdNumber = '443582.1';
        $foruthNumber = '763899.246';
        $result2 = bccomp($thirdNumber, $foruthNumber, 1);
        $this->assertSame(-1, $result2);
    }

    /**
     * @group php_base
     */
    public function testBcdiv()
    {
        $firstNumber = '45000028';
        $secondNumber = '21368784';
        $result = bcdiv($firstNumber, $secondNumber);
        $this->assertSame('2', $result);

        $thirdNumber = '19842356800';
        $foruthNumber = '411316780';
        $result2 = bcdiv($thirdNumber, $foruthNumber, 4);
        $this->assertSame('48.2410', $result2);
    }

    /**
     * @group php_base
     */
    public function testBcmod()
    {
        $firstNumber = '8341752.182';
        $secondNumber = '5000000';
        $result = bcmod($firstNumber, $secondNumber);
        $this->assertSame('3341752', $result);
    }

    /**
     * @group php_base
     */
    public function testBcmul()
    {
        $firstNumber = '25000451782.34';
        $secondNumber = '570133.422';
        $result = bcmul($firstNumber, $secondNumber, 4);
        $this->assertSame('14253593126211503.3674', $result);

        $thirdNumber = '13000000.591';
        $fourthNumber = '77611.931';
        $result2 = bcmul($thirdNumber, $fourthNumber, 2);
        $this->assertSame('1008955148868.65', $result2);
    }

    /**
     * @group php_base
     */
    public function testBcpow()
    {
        $firstNumber = '36468.42';
        $secondNumber = '13';
        $result = bcpow($firstNumber, $secondNumber, 3);
        $this->assertSame('201799609723774160616647981886537941830687143087542290885132.945', $result);
    }
}
