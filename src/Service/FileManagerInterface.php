<?php
namespace inklabs\kommerce\Service;

interface FileManagerInterface
{
    /**
     * @param string $uri
     * @return string
     */
    public function saveFile($uri);
}
