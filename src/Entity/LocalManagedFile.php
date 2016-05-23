<?php
namespace inklabs\kommerce\Entity;

class LocalManagedFile implements ManagedFileInterface
{
    /** @var string */
    private $baseFileName;

    /** @var string */
    private $fileExtension;

    /** @var string */
    private $subPath;

    /** @var string */
    private $basePath;

    /** @var int|null */
    private $imageType;

    /** @var string */
    private $mimeType;

    /** @var null | string */
    private $uriPrefix;

    public function __construct(
        $baseFileName,
        $fileExtension,
        $subPath,
        $basePath,
        $imageType,
        $mimeType,
        $uriPrefix = null
    ) {
        $this->baseFileName = (string) $baseFileName;
        $this->fileExtension = (string) $fileExtension;
        $this->subPath = (string) $subPath;
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
}
