<?php

namespace Gmi\PhpTests\Tests\xsl;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\ExtensionChecker;

use DOMDocument;
use XSLTProcessor;

class XslTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['xsl', 'dom']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    /**
     * @group php_base
     */
    public function testXSLTProcessorConstruct()
    {
        $xsldoc = new DOMDocument();
        $xsldoc->load(__DIR__ . '/Fixtures/test.xsl');

        $xmldoc = new DOMDocument();
        $xmldoc->load(__DIR__ . '/Fixtures/class.xml');

        $xsl = new XSLTProcessor();
        $this->assertInstanceOf(XSLTProcessor::class, $xsl);

        $xsl->importStyleSheet($xsldoc);
        $result = $xsl->transformToXML($xmldoc);
        // @codingStandardsIgnoreStart
        $expectedResult = '<?xml version="1.0"?>
<class><student>Jack Daniels</student><student>Harry Potter</student><student>Rebecca Steel</student><professor>Ron Bean</professor></class>
';
        // @codingStandardsIgnoreEnd
        $this->assertSame($expectedResult, $result);
    }
}
