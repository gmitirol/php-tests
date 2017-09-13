<?php

namespace Gmi\PhpTests\Tests\shmop;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\Tests\ExtensionChecker;

class ShmopTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['shmop']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    public function testShmop()
    {
        /**
         * Creates 100 byte shared memory block with system id of 0xff3, 'c' stands for create, 0644 is file permission,
         * and 100 is size in bytes. Returns INT if it is success which represents id, or false if it is not successful.
         */
        $shmId = shmop_open(0xff3, 'c', 0644, 100);

        // Additional check to be sure that shared memory block is created.
        $this->assertNotFalse($shmId);

        $shmSize = shmop_size($shmId);
        // Aditional check to see if size is 100, like we set it line before.
        $this->assertSame(100, $shmSize);

        // Returns boolean if block is deleted or not.
        $this->assertTrue(shmop_delete($shmId));
        shmop_close($shmId);
    }
}
