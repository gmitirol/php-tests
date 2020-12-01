<?php

$vendorDir = __DIR__ . '/../vendor';

if (!@include($vendorDir . '/autoload.php')) {
    $help = <<<EOT
You must set up the project dependencies, run the following commands:
wget http://getcomposer.org/composer.phar
php composer.phar install --dev

EOT;

    die($help);
}

if (PHP_VERSION_ID >= 70300 && !file_exists(__DIR__ . '/.phpunit_tests_patched')) {
    $adder = new Gmi\PhpTests\Tests\PhpunitTestPatcher();
    $results = $adder->patch(__DIR__);
    file_put_contents(__DIR__ . '/.phpunit_tests_patched', implode("\n", $results) . "\n");
}
