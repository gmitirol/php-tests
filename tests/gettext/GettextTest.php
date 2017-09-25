<?php

namespace Gmi\PhpTests\Tests\gettext;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\Tests\ExtensionChecker;

class GettextTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['gettext']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    /**
     * @group php_base
     */
    public function testGettextFunctions()
    {
        $language = 'en_US.UTF-8';
        putenv('LANG='.$language);
        $this->assertSame($language, setlocale(LC_MESSAGES, $language));

        /**
         * Set the text domain as "messages"
         * The name of your .mo file must match the $domain.
         * e.g. name your files messages.mo and call bindtextdomain("messages", $directory).
         */
        $domain =  'messages';
        bindtextdomain($domain, __DIR__ . '/Locale');
        $this->assertSame($domain, textdomain($domain));
        $this->assertSame('This is a translated text string!', gettext('example'));
    }
}
