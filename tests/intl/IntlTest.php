<?php

namespace Gmi\PhpTests\Tests\intl;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\Tests\ExtensionChecker;
use Collator;
use Locale;
use NumberFormatter;

class IntlTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['intl']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    public function testIntlEnglish()
    {
        $collator1 = new Collator('en_US');
        $local1   = $collator1->getLocale(Locale::VALID_LOCALE);
        $this->assertSame('en_US', $local1);

        $formatter2 = new NumberFormatter('en_US', NumberFormatter::DECIMAL);
        $this->assertSame('123,456', $formatter2->format(123456));
    }

    public function testIntlAustrian()
    {
        $collator2 = new Collator('de_AT');
        $local2   = $collator2->getLocale(Locale::VALID_LOCALE);
        $this->assertSame('de_AT', $local2);

        $this->markTestIncomplete();
        $formatter1 = new NumberFormatter('de_AT', NumberFormatter::DECIMAL);
        $this->assertSame('123.456', $formatter1->format(123456));
    }

    public function testIntlGerman()
    {
        $collator3 = new Collator('de_DE');
        $local3   = $collator3->getLocale(Locale::VALID_LOCALE);
        $this->assertSame('de_DE', $local3);

        $formatter3 = new NumberFormatter('de_DE', NumberFormatter::DECIMAL);
        $this->assertSame('123.456', $formatter3->format(123456));
    }
}
