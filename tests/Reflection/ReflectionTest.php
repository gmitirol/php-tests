<?php

namespace Gmi\PhpTests\Tests\Reflection;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\Tests\ExtensionChecker;
use ReflectionClass;
use ReflectionMethod;

class ReflectionTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['Reflection']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    /**
     * @group php_base
     */
    public function testReflectionClasstoString()
    {
        $reflectionClass = new ReflectionClass('Exception');
        $this->assertNotEmpty($reflectionClass->__toString());
    }

    /**
     * @group php_base
     */
    public function testReflectionClassgetExtension()
    {
        $class = new ReflectionClass('ReflectionClass');
        $extension = $class->getExtension();
        $this->assertNotEmpty($extension);
    }

    /**
     * @group php_base
     */
    public function testReflectionClassgetConstructor()
    {
        $class = new ReflectionClass('ReflectionClass');
        $constructor = $class->getConstructor();
        $this->assertNotEmpty($constructor);
        $this->assertInstanceOf(ReflectionMethod::class, $constructor);
    }

    /**
     * @group php_base
     */
    public function testReflectionClassisUserDefined()
    {
        $internalclass = new ReflectionClass('ReflectionClass');
        $result = $internalclass->isUserDefined();
        $this->assertFalse($result);
    }
}
