<?php
namespace inklabs\kommerce\Entity;

interface ManagedFileInterface
{
    /**
     * @return string
     */
    public function getUri();

    /**
     * @return string
     */
    public function getFullPath();

    /**
     * @return int
     */
    public function getImageType();

    /**
     * @return string
     */
    public function getMimeType();
}
