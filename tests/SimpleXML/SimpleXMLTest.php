<?php

namespace Gmi\PhpTests\Tests\SimpleXML;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\Tests\ExtensionChecker;

use DOMDocument;
use SimpleXMLElement;

class SimpleXMLTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['SimpleXML']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    /**
     * Check if DOM node is changed to SimpleXMLElement.
     *
     * @group php_base
     */
    public function testImportDom()
    {
        $dom = new DOMDocument;
        $dom->loadXML('<song><title>I am champion</title></song>');
        $s = simplexml_import_dom($dom);
        $this->assertInstanceOf(SimpleXMLElement::class, $s);
    }

    /**
     * @group php_base
     */
    public function testLoadString()
    {
        $string = <<<XML
        <?xml version='1.0'?>
            <document>
                <firstname>John</firstname>
                <lastname>Doe</lastname>
            </document>
XML;

        $xml = simplexml_load_string(trim($string));
        $this->assertInstanceOf(SimpleXMLElement::class, $xml);
    }

    /**
     * @group php_base
     */
    public function testLoadFile()
    {
        $xml = simplexml_load_file(__DIR__ . '/Fixtures/my.xml');

        $this->assertInstanceOf(SimpleXMLElement::class, $xml);
    }
}
