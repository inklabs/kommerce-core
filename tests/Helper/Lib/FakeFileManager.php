<?php
namespace inklabs\kommerce\tests\Helper\Lib;

use inklabs\kommerce\Entity\ManagedFileInterface;
use inklabs\kommerce\Entity\RemoteManagedFile;
use inklabs\kommerce\Lib\FileManagerInterface;

class FakeFileManager implements FileManagerInterface
{
    /**
     * @param string $sourceFilePath
     * @return ManagedFileInterface
     */
    public function saveFile($sourceFilePath)
    {
        return new RemoteManagedFile(
            'http://lorempixel.com/400/200/',
            IMAGETYPE_JPEG,
            'image/jpeg'
        );
    }
}
