<?php
namespace Gmi\PhpTests;

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
        $w = (1 === count($this->extensions)) ? 'extension' : 'extensions';

        return 'The ' . $w . ' "' . implode(',', $this->extensions) . '" must be installed!';
    }
}
