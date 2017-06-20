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

    public function __construct(string $uri, int $imageType, string $mimeType)
    {
        $this->uri = $uri;
        $this->imageType = $imageType;
        $this->mimeType = $mimeType;

        $this->width = 0;
        $this->height = 0;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getFullPath(): string
    {
        throw ManagedFileException::invalidMethodCall();
    }

    public function getImageType(): int
    {
        return $this->imageType;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }
}
