<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Exception\FileManagerException;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class LocalFileManagerTest extends EntityTestCase
{
    const FILE_PATH_JPG = __DIR__ . '/../_files/FileManager/test.jpg';
    const FILE_PATH_PNG = __DIR__ . '/../_files/FileManager/test.png';
    const FILE_PATH_GIF = __DIR__ . '/../_files/FileManager/test.gif';
    const FILE_PATH_BMP = __DIR__ . '/../_files/FileManager/test.bmp';
    const INVALID_SHORT_IMAGE = __DIR__ . '/../_files/FileManager/test.short';
    const DESTINATION_PATH = __DIR__ . '/../_files/_out';
    const URI_PREFIX = '/data/attachment';
    const REMOTE_FILE = 'http://www.example.com/robots.txt';

    /** @var LocalFileManager */
    private $fileManager;

    public function setUp()
    {
        parent::setUp();

        $this->fileManager = new LocalFileManager(
            self::DESTINATION_PATH,
            self::URI_PREFIX,
            [
                IMAGETYPE_JPEG,
                IMAGETYPE_PNG
            ]
        );
    }

    public function testSaveJpegFile()
    {
        $managedFile = $this->fileManager->saveFile(self::FILE_PATH_JPG);

        $this->assertFileExists($managedFile->getFullPath());
        unlink($managedFile->getFullPath());

        $this->assertStringStartsWith('/data/attachment/', $managedFile->getUri());
        $this->assertSame(IMAGETYPE_JPEG, $managedFile->getImageType());
        $this->assertSame('image/jpeg', $managedFile->getMimeType());
    }

    public function testSavePngFile()
    {
        $managedFile = $this->fileManager->saveFile(self::FILE_PATH_PNG);

        $this->assertFileExists($managedFile->getFullPath());
        unlink($managedFile->getFullPath());

        $this->assertSame(IMAGETYPE_PNG, $managedFile->getImageType());
        $this->assertSame('image/png', $managedFile->getMimeType());
    }

    public function testSaveGifFileFails()
    {
        $this->setExpectedException(
            FileManagerException::class,
            'Invalid uploaded image type'
        );

        $this->fileManager->saveFile(self::FILE_PATH_GIF);
    }

    public function testInvalidImageBytes()
    {
        $this->setExpectedException(
            FileManagerException::class,
            'Invalid uploaded file'
        );

        $this->fileManager->saveFile(self::INVALID_SHORT_IMAGE);
    }

    public function testInvalidDestination()
    {
        $fileManager = new LocalFileManager(__DIR__ . '/../_files/_out/missing/directory');

        $this->setExpectedException(
            FileManagerException::class,
            'Directory is not writable'
        );

        $fileManager->saveFile(self::FILE_PATH_GIF);
    }

    public function testUnsupportedFileType()
    {
        $fileManager = new LocalFileManager(
            self::DESTINATION_PATH,
            self::URI_PREFIX,
            [IMAGETYPE_BMP]
        );

        $this->setExpectedException(
            FileManagerException::class,
            'Unsupported file type'
        );

        $fileManager->saveFile(self::FILE_PATH_BMP);
    }

    public function testInvalidUploadedFile()
    {
        $this->setExpectedException(
            FileManagerException::class,
            'Invalid uploaded file'
        );

        $this->fileManager->saveFile(self::REMOTE_FILE);
    }
}
