<?php

namespace Gmi\PhpTests\Tests\xmlwriter;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\Tests\ExtensionChecker;

use XMLWriter;

class XmlwriterTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['xmlwriter']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    /**
     * @group php_base
     */
    public function testXMLWriter()
    {
        $writer = new XMLWriter();
        $writer->openMemory();
        $writer->startDocument('1.0', 'UTF-8');
        $writer->startElement('town');
        $writer->startElement('big');
        $writer->writeAttribute('town', 'Innsbruck');
        $writer->endElement();
        $writer->startElement('small');
        $writer->writeAttribute('town', 'Kuhtai');
        $writer->endElement();
        $writer->endElement();
        $writer->startElement('sport');
        $writer->startElement('summer');
        $writer->writeAttribute('sport', 'swimming');
        $writer->endElement();
        $writer->startElement('winter');
        $writer->writeAttribute('sport', 'skiing');
        $writer->endElement();
        $this->assertTrue($writer->endElement());
        $this->assertTrue($writer->endDocument());
        $result = $writer->flush();
        // @codingStandardsIgnoreStart
        $expectedResult = '<?xml version="1.0" encoding="UTF-8"?>
<town><big town="Innsbruck"/><small town="Kuhtai"/></town><sport><summer sport="swimming"/><winter sport="skiing"/></sport>
';
        // @codingStandardsIgnoreEnd
        $this->assertSame($expectedResult, $result);
    }
}
