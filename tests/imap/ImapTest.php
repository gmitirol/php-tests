<?php

namespace Gmi\PhpTests\Tests\imap;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\Tests\ExtensionChecker;

class ImapTest extends TestCase
{
    private static $emailServer;
    private static $emailUsername;
    private static $emailPassword;

    public static function setUpBeforeClass()
    {
        self::$emailServer = getenv('EMAIL_SERVER');
        self::$emailUsername = getenv('EMAIL_USERNAME');
        self::$emailPassword = getenv('EMAIL_PASSWORD');
    }

    public function setUp()
    {
        $checker = new ExtensionChecker(['imap']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }

        if (!self::$emailServer || !self::$emailUsername || !self::$emailPassword) {
            $this->markTestSkipped('Data for connecting to mailbox server is missing!');
        }
    }

    /**
     * @group php_imap
     * @group external_service
     */
    public function testImapFunctions()
    {
        $server = sprintf("{%s}INBOX", self::$emailServer);
        $mbox = @imap_open($server, self::$emailUsername, self::$emailPassword);
        $this->assertNotFalse($mbox);
        // Asserting that imap connection is still active.
        $this->assertTrue(imap_ping($mbox));

        $this->assertTrue(imap_close($mbox));

        // clear any errors (e.g. security warning - insecure connection)
        imap_errors();
    }
}
