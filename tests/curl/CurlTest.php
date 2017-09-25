<?php

namespace Gmi\PhpTests\Tests\curl;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\Tests\ExtensionChecker;

class CurlTest extends TestCase
{
    private static $host;

    public static function setUpBeforeClass()
    {
        self::$host = getenv('HTTPS_TEST_HOST');
    }

    public function setUp()
    {
        $checker = new ExtensionChecker(['curl']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }

        if (!self::$host) {
            $this->markTestSkipped('Host to make cURL session active is missing!');
        }
    }

    /**
     * Testing connection
     *
     * @group php_https
     * @group external_service
     */
    public function testCurlExec()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://' . self::$host);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);
        $this->assertNotEmpty($result);
    }
}
