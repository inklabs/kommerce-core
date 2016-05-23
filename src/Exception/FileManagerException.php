<?php
namespace inklabs\kommerce\Exception;

class FileManagerException extends Kommerce400Exception
{
    const INVALID_UPLOADED_FILE = 1;
    const FAILED_TO_COPY_FILE = 2;
    const DIRECTORY_NOT_WRITABLE = 3;
    const UNABLE_TO_CREATE_DIRECTORY = 4;
    const INVALID_UPLOADED_FILE_TYPE = 5;
    const INVALID_UPLOADED_IMAGE_TYPE = 6;
    const UNSUPPORTED_FILE_TYPE = 7;

    public static function invalidUploadedFile()
    {
        return new self('Invalid uploaded file', self::INVALID_UPLOADED_FILE);
    }

    public static function failedToCopyFile()
    {
        return new self('Failed to copy file', self::FAILED_TO_COPY_FILE);
    }

    public static function directoryNotWritable()
    {
        return new self('Directory is not writable', self::DIRECTORY_NOT_WRITABLE);
    }

    public static function unableToCreateDirectory()
    {
        return new self('Unable to create directory', self::UNABLE_TO_CREATE_DIRECTORY);
    }

    public static function invalidUploadedFileType()
    {
        return new self('Invalid uploaded file type', self::INVALID_UPLOADED_FILE_TYPE);
    }

    public static function invalidImageType()
    {
        return new self('Invalid uploaded image type', self::INVALID_UPLOADED_IMAGE_TYPE);
    }

    public static function unsupportedFileType()
    {
        return new self('Unsupported file type', self::UNSUPPORTED_FILE_TYPE);
    }
}
