<?php
namespace inklabs\kommerce\EntityDTO;

class UploadFileDTO
{
    /** @var string */
    private $origName;

    /** @var string */
    private $mimeType;

    /** @var string */
    private $filePath;

    /** @var int */
    private $size;

    public function __construct(string $origName, string $mimeType, string $filePath, int $size)
    {
        $this->origName = $origName;
        $this->mimeType = $mimeType;
        $this->filePath = $filePath;
        $this->size = $size;
    }

    public function getOrigName(): string
    {
        return $this->origName;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function getSize(): int
    {
        return $this->size;
    }
}
