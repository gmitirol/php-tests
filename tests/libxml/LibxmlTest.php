<?php

namespace Gmi\PhpTests\Tests\libxml;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\ExtensionChecker;

use SimpleXMLElement;

class LibxmlTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['libxml', 'SimpleXML']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    /**
     * Invalid XML
     *
     * @group php_base
     */
    public function testLibxmlGetErrors()
    {
        libxml_use_internal_errors(true);

        $string = <<< XML
        <?xml version='1.0' standalone='yes'?>
            <movies>
                <movie>
                    <title>Fast 7
                </movie>
            </movies>
XML;
        $xml = simplexml_load_string(trim($string));

        $this->assertFalse($xml);
        $this->assertNotEmpty(libxml_get_errors());
        libxml_clear_errors();
    }

    /**
     * Valid XML
     *
     * @group php_base
     */
    public function testLibxmlGetErrorsFalse()
    {
        libxml_use_internal_errors(true);

        $string = <<< XML
        <?xml version='1.0' standalone='yes'?>
            <movies>
                <movie>
                    <title>Fast 8</title>
                </movie>
            </movies>
XML;
        $xml = simplexml_load_string(trim($string));
        $this->assertInstanceOf(SimpleXMLElement::class, $xml);
    }
}
