<?php

namespace Gmi\PhpTests\Tests\dom;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\Tests\ExtensionChecker;

use DOMDocument;

class DomTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['dom', 'SimpleXML']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    /**
     * @group php_base
     */
    public function testImportSimplexml()
    {
        $xml = simplexml_load_string('<books><book><title>blah</title></book></books>');
        $importDomElement = dom_import_simplexml($xml);

        $dom = new DOMDocument('1.0');
        $domElement = $dom->importNode($importDomElement, true);
        $dom->appendChild($domElement);

        $expectedXml = '<?xml version="1.0"?>' . "\n" . '<books><book><title>blah</title></book></books>' . "\n";

        $this->assertInstanceOf(DOMDocument::class, $dom);
        $this->assertSame($expectedXml, $dom->saveXML());
    }
}
