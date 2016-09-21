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

    public function __construct(
        $fileExtension,
        $basePath,
        $imageType,
        $mimeType,
        $uriPrefix = null
    ) {
        $this->id = Uuid::uuid4();
        $this->baseFileName = $this->id->getHex();
        $this->subPath = $this->buildSubPath();
        $this->fileExtension = (string) $fileExtension;
        $this->basePath = (string) $basePath;
        $this->imageType = (int) $imageType;
        $this->mimeType = (string) $mimeType;

        if ($uriPrefix !== null) {
            $this->uriPrefix = (string) $uriPrefix;
        }
    }

    public function getUri()
    {
        return $this->uriPrefix . '/' . $this->getRelativePath();
    }

    public function getFullPath()
    {
        return $this->basePath . '/' . $this->getRelativePath();
    }

    public function getImageType()
    {
        return $this->imageType;
    }

    public function getMimeType()
    {
        return $this->mimeType;
    }

    private function getFileName()
    {
        return $this->baseFileName . '.' . $this->fileExtension;
    }

    private function getSubPath()
    {
        return $this->subPath;
    }

    private function getRelativePath()
    {
        return $this->getSubPath() . '/' . $this->getFileName();
    }

    private function buildSubPath()
    {
        return substr($this->baseFileName, 0, 3) . '/' . substr($this->baseFileName, 3, 3);
    }
}
