<?php

namespace Gmi\PhpTests\Tests;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\PhpunitTestPatcher;

class PhpunitTestPatcherTest extends TestCase
{
    /**
     * @group php_base
     */
    public function testPatch()
    {
        $example = file_get_contents(__DIR__ . '/Fixtures/patcher-example.txt');
        $expected = file_get_contents(__DIR__ . '/Fixtures/patcher-expected.txt');

        $testDir = __DIR__ . '/' . uniqid('', true);
        mkdir($testDir);
        $testFile = $testDir . '/ExampleTest.php';
        file_put_contents($testFile, $example);

        $patcher = new PhpunitTestPatcher();
        $results = $patcher->patch($testDir);
        $this->assertCount(4, $results);
        $this->assertSame($expected, file_get_contents($testFile));
        unlink($testFile);
        rmdir($testDir);
    }
}
