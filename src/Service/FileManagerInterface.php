<?php
namespace inklabs\kommerce\Service;

interface FileManagerInterface
{
    /**
     * @param string $filePath
     * @return string
     */
    public function saveFile($filePath);
}
