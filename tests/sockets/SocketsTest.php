<?php

namespace Gmi\PhpTests\Tests\sockets;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\Tests\ExtensionChecker;

class SocketsTest extends TestCase
{
    private static $host;

    public static function setUpBeforeClass()
    {
        self::$host = getenv('HTTPS_TEST_HOST');
    }

    public function setUp()
    {
        $checker = new ExtensionChecker(['sockets']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }

        if (!self::$host) {
            $this->markTestSkipped('Host to make socket connection valid is missing!');
        }
    }

    /**
     * @group php_https
     * @group external_service
     */
    public function testSocketConnect()
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        $address = self::$host;
        $port = 443;
        $connection = socket_connect($socket, $address, $port);
        $this->assertTrue($connection);
        socket_close($socket);
    }
}
