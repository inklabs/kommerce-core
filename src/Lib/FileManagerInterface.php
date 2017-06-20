<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Entity\ManagedFileInterface;

interface FileManagerInterface
{
    public function saveFile(string $sourceFilePath): ManagedFileInterface;
}
