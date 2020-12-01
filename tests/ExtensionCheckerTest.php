<?php

namespace Gmi\PhpTests\Tests;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\ExtensionChecker;

class ExtensionCheckerTest extends TestCase
{
    /**
     * @group php_base
     */
    public function testCheckExtensionLoaded()
    {
        $checker = new ExtensionChecker(['ctype']);
        $this->assertTrue($checker->check());
    }

    /**
     * @group php_base
     */
    public function testCheckExtensionNotLoaded()
    {
        $checker = new ExtensionChecker(['foobarbaz']);
        $this->assertFalse($checker->check());
    }

    /**
     * @group php_base
     */
    public function testGetMessageSingleExtension()
    {
        $checker = new ExtensionChecker(['baz']);
        $this->assertSame('The extension "baz" must be installed!', $checker->getMessage());
    }

    /**
     * @group php_base
     */
    public function testGetMessageMultipleExtensions()
    {
        $checker = new ExtensionChecker(['bar', 'baz']);
        $this->assertSame('The extensions "bar,baz" must be installed!', $checker->getMessage());
    }
}
