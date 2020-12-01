<?php

namespace Gmi\PhpTests\Tests\json;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\ExtensionChecker;

class JsonTest extends TestCase
{
    public function setUp()
    {
        $checker = new ExtensionChecker(['json']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }
    }

    /**
     * Decodes a JSON string.
     *
     * @group php_base
     */
    public function testJsonDecode()
    {
        $json = '{"salary":8000, "wantedSalary":9000, "age":34, "experience": 12}';
        $decodedArray = json_decode($json, true);
        $this->assertSame(['salary' => 8000, 'wantedSalary' => 9000, 'age' => 34, 'experience' => 12], $decodedArray);
    }

    /**
     * Returns the JSON representation of a value.
     *
     * @group php_base
     */
    public function testJsonEncode()
    {
        $array = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $json = json_encode($array);
        $this->assertSame('{"a":1,"b":2,"c":3,"d":4}', $json);
    }
}
