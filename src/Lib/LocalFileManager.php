<?php
namespace inklabs\kommerce\Lib;

use Exception;
use inklabs\kommerce\Entity\LocalManagedFile;
use inklabs\kommerce\Entity\ManagedFileInterface;
use inklabs\kommerce\Exception\FileManagerException;

class LocalFileManager implements FileManagerInterface
{
    const DIRECTORY_CHMOD = 0755;

    /** @var string */
    private $destinationPath;

    /** @var null|string */
    private $uriPrefix;

    /** @var int[] */
    private $allowedImageTypes;

    /**
     * Example full path:
     * /full/path/abc/def/abcdefxxx.jpg
     *
     * @param string $destinationPath /full/path
     * @param null|string $uriPrefix /uri/prefix
     * @param int[] $allowedImageTypes
     * @throws FileManagerException
     */
    public function __construct(
        string $destinationPath,
        string $uriPrefix = null,
        array $allowedImageTypes = [
            IMAGETYPE_JPEG,
            IMAGETYPE_PNG
        ]
    ) {
        $this->setDestinationPath($destinationPath);
        $this->uriPrefix = $uriPrefix;
        $this->allowedImageTypes = $allowedImageTypes;
    }

    public function saveFile(string $sourceFilePath): ManagedFileInterface
    {
        $this->checkDestination();
        $this->checkUploadedFile($sourceFilePath);
        $this->checkValidImage($sourceFilePath);

        $fileExtension = $this->getFileExtension($sourceFilePath);
        $imageType = $this->getImageType($sourceFilePath);
        $mimeType = $this->getMimeType($imageType);

        list($width, $height) = getimagesize($sourceFilePath);

        $managedFile = new LocalManagedFile(
            $fileExtension,
            $this->destinationPath,
            $imageType,
            $mimeType,
            $width,
            $height,
            $this->uriPrefix
        );

        $this->copy($sourceFilePath, $managedFile->getFullPath());

        return $managedFile;
    }

    private function copy(string $sourceFilePath, string $destinationFilePath): void
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

    private function setDestinationPath(string $destinationPath): void
    {
        $this->destinationPath = $destinationPath;
    }

    private function getFileExtension(string $sourceFilePath): string
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

    protected function createDirectory(string $directoryPath): void
    {
        try {
            if (mkdir($directoryPath, self::DIRECTORY_CHMOD, true)) {
                return;
            }
        } catch (Exception $e) {
        }

        throw FileManagerException::unableToCreateDirectory();
    }

    private function getMimeType(int $imageType): string
    {
        return image_type_to_mime_type($imageType);
    }

    private function getImageType(string $filePath): int
    {
        return exif_imagetype($filePath);
    }

    private function checkUploadedFile(string $sourceFilePath)
    {
        if (! is_uploaded_file($sourceFilePath)) {
            throw FileManagerException::invalidUploadedFile();
        }
    }

    private function checkValidImage(string $sourceFilePath)
    {
        if (! $this->imageIsLargeEnoughToReadFirstBytes($sourceFilePath)) {
            throw FileManagerException::invalidUploadedFile();
        }

        $imageType = $this->getImageType($sourceFilePath);
        if (! in_array($imageType, $this->allowedImageTypes)) {
            throw FileManagerException::invalidImageType();
        }
    }

    private function imageIsLargeEnoughToReadFirstBytes(string $sourceFilePath): bool
    {
        return filesize($sourceFilePath) > 11;
    }

    protected function checkDestination(): void
    {
        if (! is_dir($this->destinationPath) || ! is_writable(realpath($this->destinationPath))) {
            throw FileManagerException::directoryNotWritable();
        }
    }
}
