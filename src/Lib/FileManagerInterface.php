<?php
namespace inklabs\kommerce\Lib;

interface FileManagerInterface
{
    /**
     * @param string $filePath
     * @return string
     */
    public function saveFile($filePath);
}
