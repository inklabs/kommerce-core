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

    /**
     * @param string $origName 42-348301152.jpg
     * @param string $mimeType image/jpeg
     * @param string $filePath /tmp/php5BBVYd
     * @param int $size
     */
    public function __construct($origName, $mimeType, $filePath, $size)
    {
        $this->origName = $origName;
        $this->mimeType = $mimeType;
        $this->filePath = $filePath;
        $this->size = $size;
    }

    public function getOrigName()
    {
        return $this->origName;
    }

    public function getMimeType()
    {
        return $this->mimeType;
    }

    public function getFilePath()
    {
        return $this->filePath;
    }

    public function getSize()
    {
        return $this->size;
    }
}
