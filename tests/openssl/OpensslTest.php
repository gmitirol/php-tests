<?php

namespace Gmi\PhpTests\Tests\openssl;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\Tests\ExtensionChecker;

class OpensslTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['openssl']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    /**
     * @group php_base
     */
    public function testOpensslCsrExport()
    {
        $subject = ['commonName' => 'example.com'];

        $privateKey = openssl_pkey_new(['private_key_bits' => 2048, 'private_key_type' => OPENSSL_KEYTYPE_RSA]);
        $this->assertNotFalse($privateKey);

        $configArgs = ['digest_alg' => 'sha256WithRSAEncryption'];

        $csr = openssl_csr_new($subject, $privateKey, $configArgs);

        $out = '';
        $this->assertTrue(openssl_csr_export($csr, $out));
        $this->assertStringStartsWith('-----BEGIN CERTIFICATE REQUEST-----', $out);
    }

    /**
     * @group php_base
     */
    public function testOpensslSpkiNew()
    {
        $config = ['digest_alg' => 'sha512', 'private_key_bits' => 4096, 'private_key_type' => OPENSSL_KEYTYPE_RSA];
        $privateKey = openssl_pkey_new($config);
        $this->assertNotFalse($privateKey);
        
        // Create a Signed Public Key and Challenge.
        $spkac = openssl_spki_new($privateKey, 'testing');
        $this->assertNotEmpty($spkac);
    }
}
