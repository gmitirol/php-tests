<?php

namespace Gmi\PhpTests\Tests\session;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\Tests\ExtensionChecker;

class SessionTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['session']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    /**
     * @group php_base
     */
    public function testSessionFunctions()
    {
        @session_start();

        $_SESSION['favcolor'] = 'blue';
        $_SESSION['favanimal'] = 'eagle';
        $this->assertSame('blue', $_SESSION['favcolor']);
        $this->assertSame('eagle', $_SESSION['favanimal']);

        session_cache_expire(40);
        $cacheExpire = session_cache_expire();
        $this->assertSame(40, $cacheExpire);

        session_cache_limiter('private');
        $cacheLimiter = session_cache_limiter();
        $this->assertSame('private', $cacheLimiter);

        $sessionName = session_name();
        $this->assertSame('PHPSESSID', $sessionName);

        @session_destroy();
        session_abort();
    }
}
