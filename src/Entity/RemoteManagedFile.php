<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Exception\ManagedFileException;

class RemoteManagedFile implements ManagedFileInterface
{
    /** @var string */
    private $uri;

    /** @var int */
    private $imageType;

    /** @var string */
    private $mimeType;

    /** @var int */
    private $width;

    /** @var int */
    private $height;

    /**
     * @param string $uri
     * @param int $imageType
     * @param string $mimeType
     */
    public function __construct($uri, $imageType, $mimeType)
    {
        $this->uri = (string) $uri;
        $this->imageType = (int) $imageType;
        $this->mimeType = (string) $mimeType;

        $this->width = 0;
        $this->height = 0;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getFullPath()
    {
        throw ManagedFileException::invalidMethodCall();
    }

    public function getImageType()
    {
        return $this->imageType;
    }

    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }
}
