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
     */
    public function testImportDom()
    {
        $dom = new DOMDocument;
        $dom->loadXML('<song><title>I am champion</title></song>');
        $s = simplexml_import_dom($dom);
        $this->assertInstanceOf(SimpleXMLElement::class, $s);
    }

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

    public function testLoadFile()
    {
        if (file_exists(__DIR__ . '/Fixtures/my.xml')) {
            $xml = simplexml_load_file(__DIR__ . '/Fixtures/my.xml');
        } else {
            return('Failed to open my.xml file');
        }
        $this->assertInstanceOf(SimpleXMLElement::class, $xml);
    }
}
