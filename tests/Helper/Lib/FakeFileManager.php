<?php
namespace inklabs\kommerce\tests\Helper\Lib;

use inklabs\kommerce\Service\FileManagerInterface;

class FakeFileManager implements FileManagerInterface
{
    /**
     * @param string $uri
     * @return string
     */
    public function saveFile($uri)
    {
        return 'http://lorempixel.com/400/200/';
    }
}
