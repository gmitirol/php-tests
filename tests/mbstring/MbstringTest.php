<?php

namespace Gmi\PhpTests\Tests\mbstring;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\Tests\ExtensionChecker;

class MbstringTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['mbstring']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    public function testMbStrtoupper()
    {
        $this->assertSame('GODZILLA', mb_strtoupper('godzilla'));
    }

    public function testMbStrtolower()
    {
        $this->assertSame('invisible guy', mb_strtolower('INVISIBLE Guy'));
    }

    public function testMbStrlen()
    {
        $this->assertSame(7, mb_strlen('Vrlazić'));
    }

    public function testMbSubstr()
    {
        $this->assertSame('CHÁ', mb_substr('CHÁRÊCTËRS', 0, 3));
    }

    public function testMbSubstrCount()
    {
        $this->assertSame(1, mb_substr_count('this is a  Ëxtra test', 'Ë'));
    }

    public function testMbSplit()
    {
        $this->assertSame(
            ['ΤΆΧΙΣΤΗ', 'ΑΛΏΠΗΞ', 'ΒΑΦΉΣ', 'ΨΗΜΈΝΗ', 'ΓΗ,', 'ΔΡΑΣΚΕΛΊΖΕΙ', 'ΥΠΈΡ', 'ΝΩΘΡΟΎ', 'ΚΥΝΌΣ'],
            mb_split('\s', 'ΤΆΧΙΣΤΗ ΑΛΏΠΗΞ ΒΑΦΉΣ ΨΗΜΈΝΗ ΓΗ, ΔΡΑΣΚΕΛΊΖΕΙ ΥΠΈΡ ΝΩΘΡΟΎ ΚΥΝΌΣ')
        );
    }

    public function testMbStrtoupperSpecialCharacters()
    {
        $this->assertSame('ŽĆŠĐČ', mb_strtoupper('žćšđč'));
    }

    public function testMbStrtolowerSpecialCharacters()
    {
        $this->assertSame('pršljenčić', mb_strtolower('PRŠLJENČIĆ'));
    }

    // Greek Alphabet
    public function testMbStrwidth()
    {
        $this->assertSame(12, mb_strwidth('βγΔδεζηΘκΛλμ'));
    }

    // Serbian Cyrillic alphabet
    public function testMbStrstrFalseCase()
    {
        $this->assertSame(false, mb_strstr('АБВГДЂЕ  ЖЗИЈКЛ ЉМНЊОПРСТЋУФЦЧЏШ', 'test'));
    }

    public function testMbStrstrValidCase()
    {
        $this->assertSame('genius', mb_strstr('hugo hackerman is genius', 'genius'));
    }

    public function testMbStrrpos()
    {
        $this->assertSame(6, mb_strrpos('ふーばー, ふー', 'ふー'));
    }

    public function testMbStrcut()
    {
        $this->assertSame('R OH', mb_strcut('I_R OHA', 2, 4));
    }

    public function testMbConvertCase()
    {
        $this->assertSame(
            'ΤΆΧΙΣΤΗ ΑΛΏΠΗΞ ΒΑΦΉΣ ΨΗΜΈΝΗ ΓΗ, ΔΡΑΣΚΕΛΊΖΕΙ ΥΠΈΡ ΝΩΘΡΟΎ ΚΥΝΌΣ',
            mb_convert_case('Τάχιστη αλώπηξ βαφής ψημένη γη, δρασκελίζει υπέρ νωθρού κυνός', MB_CASE_UPPER, 'UTF-8')
        );

        $this->assertSame(
            'Mr.robot Lives For The Hacking',
            mb_convert_case('mr.robot LIVES FOR THE HACKING', MB_CASE_TITLE, 'UTF-8')
        );

        $this->assertSame(
            'hackerman was champion of the world',
            mb_convert_case('HACKERMAN was champion of the World', MB_CASE_LOWER, 'UTF-8')
        );
    }
}
