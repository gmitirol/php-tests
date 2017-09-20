<?php

namespace Gmi\PhpTests\Tests\pcre;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\Tests\ExtensionChecker;

class PcreTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['pcre']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    /**
     * @group php_base
     */
    public function testPregSplitWord()
    {
        $word = 'ValidExample';
        $characters = preg_split('//', $word, -1, PREG_SPLIT_NO_EMPTY);
        $result = ['V', 'a', 'l', 'i', 'd', 'E', 'x', 'a', 'm', 'p', 'l', 'e'];
        $this->assertSame($result, $characters);
    }

    /**
     * @group php_base
     */
    public function testPregSplitWords()
    {
        $words = preg_split("/[\s]+/", 'hypertext language, programming, software development, cloud computing');
        $result = ['hypertext', 'language,', 'programming,', 'software', 'development,', 'cloud', 'computing'];
        $this->assertSame($result, $words);
    }

    /**
     * @group php_base
     */
    public function testPregReplace()
    {
        $string = 'Joe Hackerman is great in hack.';
        $patterns = array();
        $patterns[0] = '/great/';
        $patterns[1] = '/in/';
        $replacements = array();
        $replacements[1] = 'bad';
        $replacements[0] = 'at';
        $result = preg_replace($patterns, $replacements, $string);
        $expectedResult = 'Joe Hackerman is bad at hack.';
        $this->assertSame($expectedResult, $result);
    }
}
