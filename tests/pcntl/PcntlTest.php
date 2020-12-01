<?php

namespace Gmi\PhpTests\Tests\pcntl;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\ExtensionChecker;

class PcntlTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['pcntl']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    /**
     * @group php_base
     */
    public function testPcntlExec()
    {
        $path = __DIR__ . '/Fixtures/test.sh';

        $pid = pcntl_fork();
        $this->assertNotSame(-1, $pid);

        if (!$pid) {
            usleep(1000);
            fclose(STDOUT);
            $STDOUT = fopen('/dev/null', 'wb');
            pcntl_exec($path);
        }

        while (pcntl_waitpid(0, $status) !== -1) {
            $this->assertSame(0, pcntl_wexitstatus($status));
        }
    }
}
