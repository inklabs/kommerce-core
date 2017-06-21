<?php
namespace inklabs\kommerce\tests\Helper\Lib;

use inklabs\kommerce\Lib\LocalFileManager;

class IgnoreDestinationLocalFileManager extends LocalFileManager
{
    protected function checkDestination(): void
    {
    }

    protected function createDirectory(string $directoryPath): void
    {
    }
}
