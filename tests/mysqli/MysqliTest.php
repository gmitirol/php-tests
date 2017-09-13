<?php

namespace Gmi\PhpTests\Tests\mysqli;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\Tests\ExtensionChecker;
use mysqli;

class MysqliTest extends TestCase
{
    private static $mySqlHost;
    private static $mySqlPort;
    private static $mySqlDb;
    private static $mySqlUser;
    private static $mySqlPassword;

    public static function setUpBeforeClass()
    {
        self::$mySqlHost = getenv('MYSQL_HOST');
        self::$mySqlPort = getenv('MYSQL_PORT');
        self::$mySqlDb = getenv('MYSQL_DATABASE');
        self::$mySqlUser = getenv('MYSQL_USER');
        self::$mySqlPassword = getenv('MYSQL_PASSWORD');
    }

    public function setUp()
    {
        $checker = new ExtensionChecker(['mysqli']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }

        if (!self::$mySqlHost || !self::$mySqlPort || !self::$mySqlDb || !self::$mySqlUser || !self::$mySqlPassword) {
            $this->markTestSkipped('Data for connecting to database is missing!');
        }
    }

    public function testMysqliConnection()
    {
        $mysqli = new mysqli(
            self::$mySqlHost,
            self::$mySqlUser,
            self::$mySqlPassword,
            self::$mySqlDb,
            self::$mySqlPort
        );

        $this->assertTrue($mysqli->ping());
        $query = 'SHOW DATABASES';
        $result = $mysqli->query($query);
        $rows = $result->fetch_all();

        $found = false;
        foreach ($rows as $row) {
            if ($row[0] === self::$mySqlDb) {
                $found = true;
            }
        }

        $this->assertTrue($found);
    }
}
