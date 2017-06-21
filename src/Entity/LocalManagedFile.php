<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

class LocalManagedFile implements ManagedFileInterface
{
    /** @var UuidInterface */
    private $id;

    /** @var string */
    private $baseFileName;

    /** @var string */
    private $fileExtension;

    /** @var string */
    private $subPath;

    /** @var string */
    private $basePath;

    /** @var int */
    private $imageType;

    /** @var string */
    private $mimeType;

    /** @var null|string */
    private $uriPrefix;

    /** @var int */
    private $width;

    /** @var int */
    private $height;

    public function __construct(
        string $fileExtension,
        string $basePath,
        int $imageType,
        string $mimeType,
        int $width,
        int $height,
        string $uriPrefix = null
    ) {
        $this->id = Uuid::uuid4();
        $this->baseFileName = $this->id->getHex();
        $this->subPath = $this->buildSubPath();
        $this->fileExtension = $fileExtension;
        $this->basePath = $basePath;
        $this->imageType = $imageType;
        $this->mimeType = $mimeType;
        $this->width = $width;
        $this->height = $height;

        if ($uriPrefix !== null) {
            $this->uriPrefix = $uriPrefix;
        }
    }

    public function getUri(): string
    {
        return $this->uriPrefix . '/' . $this->getRelativePath();
    }

    public function getFullPath(): string
    {
        return $this->basePath . '/' . $this->getRelativePath();
    }

    public function getImageType(): int
    {
        return $this->imageType;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    private function getFileName(): string
    {
        return $this->baseFileName . '.' . $this->fileExtension;
    }

    private function getSubPath(): string
    {
        return $this->subPath;
    }

    private function getRelativePath(): string
    {
        return $this->getSubPath() . '/' . $this->getFileName();
    }

    private function buildSubPath(): string
    {
        return substr($this->baseFileName, 0, 3) . '/' . substr($this->baseFileName, 3, 3);
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
