<?php
namespace inklabs\kommerce\tests\Helper\Lib;

use inklabs\kommerce\Lib\FileManagerInterface;

class FakeFileManager implements FileManagerInterface
{
    /**
     * @param string $filePath
     * @return string
     */
    public function saveFile($filePath)
    {
        return 'http://lorempixel.com/400/200/';
    }
}
