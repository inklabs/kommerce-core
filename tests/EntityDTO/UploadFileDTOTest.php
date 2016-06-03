<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class UploadFileDTOTest extends EntityTestCase
{
    public function testCreate()
    {
        $origName = '42-348301152.jpg';
        $mimeType = 'image/jpeg';
        $filePath = '/tmp/phpupuP2I';
        $size = 236390;

        $uploadFile = new UploadFileDTO(
            $origName,
            $mimeType,
            $filePath,
            $size
        );

        $this->assertSame($origName, $uploadFile->getOrigName());
        $this->assertSame($mimeType, $uploadFile->getMimeType());
        $this->assertSame($filePath, $uploadFile->getFilePath());
        $this->assertSame($size, $uploadFile->getSize());
    }
}
