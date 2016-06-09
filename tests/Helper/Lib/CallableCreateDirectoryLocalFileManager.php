<?php
namespace inklabs\kommerce\tests\Helper\Lib;

use inklabs\kommerce\Lib\LocalFileManager;

class CallableCreateDirectoryLocalFileManager extends LocalFileManager
{
    public function callCreateDirectory($directoryPath)
    {
        $this->createDirectory($directoryPath);
    }
}
