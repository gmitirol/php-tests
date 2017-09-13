<?php
namespace Gmi\PhpTests\Tests;

class ExtensionChecker
{
    private $extensions = [];

    public function __construct($extensions)
    {
        $this->extensions = $extensions;
    }

    public function check()
    {
        foreach ($this->extensions as $extension) {
            if (!extension_loaded($extension)) {
                return false;
            }
        }

        return true;
    }

    public function getMessage()
    {
        return 'The extensions "' . implode(',', $this->extensions) . '" must be installed!';
    }
}
