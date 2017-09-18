<?php

namespace Gmi\PhpTests\Tests\tokenizer;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\Tests\ExtensionChecker;

class TokenizerTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['tokenizer']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    /**
     * @group php_base
     */
    public function testTokenizerFunctions()
    {
        $tokens = token_get_all('<?php echo; ?>');
        $this->assertSame('T_OPEN_TAG', token_name($tokens[0][0]));
        $this->assertSame('T_ECHO', token_name($tokens[1][0]));
        $this->assertSame('T_WHITESPACE', token_name($tokens[3][0]));
        $this->assertSame('T_CLOSE_TAG', token_name($tokens[4][0]));
    }
}
