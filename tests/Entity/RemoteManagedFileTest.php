<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Exception\ManagedFileException;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class RemoteManagedFileTest extends EntityTestCase
{
    public function testCreate()
    {
        $uri = 'http://lorempixel.com/400/200/';
        $imageType = IMAGETYPE_JPEG;
        $mimeType = 'image/jpeg';

        $remoteManagedFile = new RemoteManagedFile($uri, $imageType, $mimeType);

        $this->assertSame($uri, $remoteManagedFile->getUri());
        $this->assertSame($imageType, $remoteManagedFile->getImageType());
        $this->assertSame($mimeType, $remoteManagedFile->getMimeType());
    }

    public function testGetFullPathFails()
    {
        $remoteManagedFile = $this->dummyData->getRemoteManagedFile();

        $this->setExpectedException(
            ManagedFileException::class,
            'Invalid method call'
        );

        $remoteManagedFile->getFullPath();
    }
}
