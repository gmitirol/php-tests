<?php
/**
 * Patcher for PHPUnit tests.
 *
 * @copyright 2020 Institute of Legal Medicine, Medical University of Innsbruck
 * @author Andreas Erhard <andreas.erhard@i-med.ac.at>
 * @license LGPL-3.0-only
 * @link http://www.gerichtsmedizin.at/
 *
 * @package php-tests
 */

namespace Gmi\PhpTests;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * This Patcher adds :void typehints to the PHPUnit setUp/TearDown methods of test classes.
 */
class PhpunitTestPatcher
{
    /**
     * Patches PHPunit test files in the provided directory.
     *
     * @param string $directory
     *
     * @return string[]
     */
    public function patch(string $directory): array
    {
        $results = [];
        $iterator = new RecursiveDirectoryIterator($directory);

        $replace = [
            "public static function setUpBeforeClass()\n",
            "public function setUp()\n",
            "public function tearDown()\n",
            "public static function tearDownAfterClass()\n",
        ];

        foreach (new RecursiveIteratorIterator($iterator) as $file) {
            if (false === strpos($file, 'Test.php')) {
                continue;
            }

            $content = file_get_contents($file);
            foreach ($replace as $r) {
                $count = 0;
                $content = str_replace($r, rtrim($r) . ": void\n", $content, $count);
                if ($count > 0) {
                    $results[] = sprintf('Adding type hint for %s in %s', $r, $file);
                }
            }

            file_put_contents($file, $content);
        }

        return $results;
    }
}
