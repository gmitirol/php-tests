<?php

namespace Gmi\PhpTests\Tests\SPL;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\Tests\ExtensionChecker;

use Exception;
use RangeException;
use RuntimeException;

class SPLTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['SPL']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    /**
     * @group php_base
     */
    public function testSplClasses()
    {
        $result = spl_classes();
        $this->assertNotEmpty($result);
        $this->assertArrayHasKey('ArrayIterator', $result);
        $this->assertArrayHasKey('SplFileObject', $result);
        $this->assertArrayHasKey('SplObserver', $result);
    }

    /**
     * @group php_base
     */
    public function testSplAutoloadFunctions()
    {
        $autoloaderRegistered = spl_autoload_register(function ($class) {
           // do nothing
        });

        $this->assertTrue($autoloaderRegistered);
        $result = spl_autoload_functions();
        $this->assertNotEmpty($result);
    }

    /**
     * @group php_base
     */
    public function testSplExceptions()
    {
        $exception = new RangeException('Test');
        $parentExceptions = class_parents($exception);

        $this->assertArrayHasKey(RuntimeException::class, $parentExceptions);
        $this->assertArrayHasKey(Exception::class, $parentExceptions);
    }
}
