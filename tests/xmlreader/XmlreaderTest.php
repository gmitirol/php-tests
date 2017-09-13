<?php

namespace Gmi\PhpTests\Tests\xmlreader;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\Tests\ExtensionChecker;
use XMLReader;

class XmlreaderTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['xmlreader']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    public function testXMLReaderOpen()
    {
        $reader = new XMLReader();
        // Check if data file can be opened.
        $file = $reader->open(__DIR__ . '/Fixtures/cars.xml');
        $this->assertTrue($file);
    }

    public function testXMLReaderReadInnerXml()
    {
        $xmlReader = new XMLReader();
        $xmlReader->open(__DIR__ . '/Fixtures/cars.xml');
        $node = $xmlReader->next();
        $this->assertNotEmpty($xmlReader->readInnerXml());
    }
}
