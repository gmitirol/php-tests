<?php

namespace Gmi\PhpTests\Tests\PDO;

use PHPUnit\Framework\TestCase;

use Gmi\PhpTests\Tests\ExtensionChecker;
use PDO;

class PDOTest extends TestCase
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
        $checker = new ExtensionChecker(['PDO']);
        if ($checker->check() === false) {
            $this->markTestSkipped($checker->getMessage());
        }

        if (!self::$mySqlHost || !self::$mySqlPort || !self::$mySqlDb || !self::$mySqlUser || !self::$mySqlPassword) {
            $this->markTestSkipped('Data for creating PDO instance is missing!');
        }
    }

    public function testPDOInstance()
    {
        $dsn = sprintf('mysql:dbname=%s;port=%s;host=%s', self::$mySqlDb, self::$mySqlPort, self::$mySqlHost);
        $pdo = new PDO($dsn, self::$mySqlUser, self::$mySqlPassword);

        $table = 'MyFavHeroes' . md5(uniqid('', true));

        $sql = "CREATE TABLE $table (
                id INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                firstname VARCHAR(30) NOT NULL,
                lastname VARCHAR(30) NOT NULL,
                color VARCHAR(40) NOT NULL)";
        $pdo->query($sql);

        $sql = "INSERT INTO $table (id, firstname, lastname, color)
                VALUES (1,'Chuck','Norris', 'red');";
        $pdo->query($sql);

        $sql = "INSERT INTO $table (id, firstname, lastname, color)
                VALUES (2,'Robin','Hood', 'blue');";
        $pdo->query($sql);

        $sql = "SELECT firstname, lastname FROM $table WHERE color=:color";
        $dbst = $pdo->prepare($sql);
        $dbst->execute([':color' => 'red']);
        $result = $dbst->fetch();
        $this->assertSame('Chuck', $result[0]);
        $this->assertSame('Norris', $result[1]);

        $sql = "DROP TABLE $table;";
        $pdo->query($sql);
    }
}
