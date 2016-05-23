<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Entity\ManagedFileInterface;

interface FileManagerInterface
{
    /**
     * @param string $sourceFilePath
     * @return ManagedFileInterface
     */
    public function saveFile($sourceFilePath);
}
