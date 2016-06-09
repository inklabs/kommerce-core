<?php
namespace inklabs\kommerce\Lib;

use Exception;
use inklabs\kommerce\Entity\LocalManagedFile;
use inklabs\kommerce\Entity\ManagedFileInterface;
use inklabs\kommerce\Exception\FileManagerException;

class LocalFileManager implements FileManagerInterface
{
    const DIRECTORY_CHMOD = 0744;

    /** @var string */
    private $destinationPath;

    /** @var null | string */
    private $uriPrefix;

    /** @var int[] */
    private $allowedImageTypes;

    /**
     * Example full path:
     * /full/path/abc/def/abcdefxxx.jpg
     *
     * @param string $destinationPath /full/path
     * @param null | string $uriPrefix /uri/prefix
     * @param int[] $allowedImageTypes
     * @throws FileManagerException
     */
    public function __construct(
        $destinationPath,
        $uriPrefix = null,
        $allowedImageTypes = [
            IMAGETYPE_JPEG,
            IMAGETYPE_PNG
        ]
    ) {
        $this->setDestinationPath($destinationPath);
        $this->uriPrefix = $uriPrefix;
        $this->allowedImageTypes = $allowedImageTypes;
    }

    /**
     * @param string $sourceFilePath
     * @return ManagedFileInterface
     * @throws FileManagerException
     */
    public function saveFile($sourceFilePath)
    {
        $this->checkDestination();
        $this->checkUploadedFile($sourceFilePath);
        $this->checkValidImage($sourceFilePath);

        $fileExtension = $this->getFileExtension($sourceFilePath);
        $imageType = $this->getImageType($sourceFilePath);
        $mimeType = $this->getMimeType($imageType);

        $managedFile = new LocalManagedFile(
            $fileExtension,
            $this->destinationPath,
            $imageType,
            $mimeType,
            $this->uriPrefix
        );

        $this->copy($sourceFilePath, $managedFile->getFullPath());

        return $managedFile;
    }

    /**
     * @param string $sourceFilePath
     * @param string $destinationFilePath
     * @throws FileManagerException
     */
    private function copy($sourceFilePath, $destinationFilePath)
    {
        $this->createDirectory(dirname($destinationFilePath));

        try {
            if (copy($sourceFilePath, $destinationFilePath)) {
                return;
            }
        } catch (Exception $e) {
        }

        throw FileManagerException::failedToCopyFile();
    }

    /**
     * @param string $destinationPath
     * @throws FileManagerException
     */
    private function setDestinationPath($destinationPath)
    {
        $this->destinationPath = $destinationPath;
    }

    /**
     * @param string $sourceFilePath
     * @return string
     * @throws FileManagerException
     */
    private function getFileExtension($sourceFilePath)
    {
        $mimeType = exif_imagetype($sourceFilePath);

        switch ($mimeType) {
            case IMAGETYPE_JPEG:
                return 'jpg';
                break;
            case IMAGETYPE_PNG:
                return 'png';
                break;
            default:
                throw FileManagerException::unsupportedFileType();
        }
    }

    /**
     * @param string $directoryPath
     * @throws FileManagerException
     */
    protected function createDirectory($directoryPath)
    {
        try {
            if (mkdir($directoryPath, self::DIRECTORY_CHMOD, true)) {
                return;
            }
        } catch (Exception $e) {
        }

        throw FileManagerException::unableToCreateDirectory();
    }

    /**
     * @param int $imageType
     * @return string
     */
    private function getMimeType($imageType)
    {
        return image_type_to_mime_type($imageType);
    }

    /**
     * @param string $filePath
     * @return int
     */
    private function getImageType($filePath)
    {
        return exif_imagetype($filePath);
    }

    /**
     * @param string $sourceFilePath
     * @throws FileManagerException
     */
    private function checkUploadedFile($sourceFilePath)
    {
        if (! is_uploaded_file($sourceFilePath)) {
            throw FileManagerException::invalidUploadedFile();
        }
    }

    /**
     * @param string $sourceFilePath
     * @throws FileManagerException
     */
    private function checkValidImage($sourceFilePath)
    {
        if (! $this->imageIsLargeEnoughToReadFirstBytes($sourceFilePath)) {
            throw FileManagerException::invalidUploadedFile();
        }

        $imageType = $this->getImageType($sourceFilePath);
        if (! in_array($imageType, $this->allowedImageTypes)) {
            throw FileManagerException::invalidImageType();
        }
    }

    /**
     * @param string $sourceFilePath
     * @return bool
     */
    private function imageIsLargeEnoughToReadFirstBytes($sourceFilePath)
    {
        return filesize($sourceFilePath) > 11;
    }

    protected function checkDestination()
    {
        if (! is_dir($this->destinationPath) || ! is_writable(realpath($this->destinationPath))) {
            throw FileManagerException::directoryNotWritable();
        }
    }
}
