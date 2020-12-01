<?php

namespace Gmi\PhpTests\Tests\hash;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\ExtensionChecker;

class HashTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['hash']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    /**
     * @group php_base
     */
    public function testHashMd5()
    {
        $result = hash('md5', 'The quick brown fox jumped over the lazy dog.', false);

        $this->assertSame('5c6ffbdd40d9556b73a21e63c3e0e904', $result);
    }

    /**
     * @group php_base
     */
    public function testSha1()
    {
        $result = hash('sha1', 'The quick brown fox jumped over the lazy dog.', false);
        $this->assertSame('c0854fb9fb03c41cce3802cb0d220529e6eef94e', $result);
    }

    /**
     * @group php_base
     */
    public function testSha256()
    {
        $result = hash('sha256', 'The quick brown fox jumped over the lazy dog.', false);
        $this->assertSame('68b1282b91de2c054c36629cb8dd447f12f096d3e3c587978dc2248444633483', $result);
    }

    /**
     * @group php_base
     */
    public function testSha512()
    {
        $result = hash('sha512', 'The quick brown fox jumped over the lazy dog.', false);

        $this->assertSame('0a8c150176c2ba391d7f1670ef4955cd99d3c3ec8cf06198cec30d436f2ac0c9b'
                . '64229b5a54bdbd5563160503ce992a74be528761da9d0c48b7c74627302eb25', $result);
    }
}
