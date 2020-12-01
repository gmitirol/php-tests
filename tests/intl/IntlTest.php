<?php

namespace Gmi\PhpTests\Tests\intl;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\ExtensionChecker;
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

    /**
     * @group php_base
     */
    public function testIntlEnglish()
    {
        $collator = new Collator('en_US');
        $locale = $collator->getLocale(Locale::VALID_LOCALE);
        $this->assertSame('en_US', $locale);

        $formatter = new NumberFormatter('en_US', NumberFormatter::DECIMAL);
        $this->assertSame('123,456', $formatter->format(123456));
    }

    /**
     * @group php_base
     */
    public function testIntlAustrian()
    {
        $collator = new Collator('de_AT');
        $locale = $collator->getLocale(Locale::VALID_LOCALE);
        $this->assertSame('de_AT', $locale);

        $formatter = new NumberFormatter('de_AT', NumberFormatter::DECIMAL);
        # Dot as decimal separator for ICU <= 55, non-breaking space for later ICU versions
        $this->assertTrue(in_array($formatter->format(123456), ['123.456', "123\xc2\xa0456"]));
    }

    /**
     * @group php_base
     */
    public function testIntlGerman()
    {
        $collator = new Collator('de_DE');
        $locale = $collator->getLocale(Locale::VALID_LOCALE);
        # de_DE on PHP5, de on PHP7
        $this->assertTrue(in_array($locale, ['de_DE', 'de']));

        $formatter = new NumberFormatter('de_DE', NumberFormatter::DECIMAL);
        $this->assertSame('123.456', $formatter->format(123456));
    }

    /**
     * The non-breakable space as group separator (as defined in ICU56+ for Austria) can cause
     * problems if the application can't deal with such formatted numbers.
     *
     * @group php_base
     */
    public function testDefaultLocaleHasNoNbspAsGroupSeparator()
    {
        $defaultLocale = Locale::getDefault();
        $formatter = new NumberFormatter($defaultLocale, NumberFormatter::DECIMAL);
        $this->assertNotSame("\xc2\xa", $formatter->getSymbol(NumberFormatter::GROUPING_SEPARATOR_SYMBOL));
    }
}
