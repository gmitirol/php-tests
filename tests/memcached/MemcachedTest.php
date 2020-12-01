<?php

namespace Gmi\PhpTests\Tests\memcached;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\ExtensionChecker;
use Memcached;

class MemcachedTest extends TestCase
{
    private static $memcachedHost;
    private static $memcachedPort;

    public static function setUpBeforeClass()
    {
        self::$memcachedHost = getenv('MEMCACHED_HOST');
        self::$memcachedPort = getenv('MEMCACHED_PORT');
    }

    public function setUp()
    {
        $checker = new ExtensionChecker(['memcached']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }

        if (!self::$memcachedHost || !self::$memcachedPort) {
            $this->markTestSkipped('Data for connecting to memcached is missing!');
        }
    }

    /**
     * @group php_memcached
     * @group external_service
     */
    public function testMemcachedConnection()
    {
        $memcached = new Memcached();
        $this->assertTrue($memcached->addServer(self::$memcachedHost, self::$memcachedPort));
        $key = md5(uniqid('', true));
        $date = date('c');
        $this->assertTrue($memcached->set($key, $date));
        $this->assertSame($date, $memcached->get($key));
        $this->assertTrue($memcached->delete($key));
    }
}
