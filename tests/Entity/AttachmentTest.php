<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;
use Ramsey\Uuid\UuidInterface;

class AttachmentTest extends EntityTestCase
{
    public function testCreate()
    {
        $filePath = 'img/example.png';
        $attachment = new Attachment($filePath);

        $this->assertEntityValid($attachment);
        $this->assertTrue($attachment->getId() instanceof UuidInterface);
        $this->assertTrue($attachment->getCreated()->getTimestamp() > 0);
        $this->assertTrue($attachment->isVisible());
        $this->assertFalse($attachment->isLocked());
        $this->assertSame(null, $attachment->getUpdated());
        $this->assertSame($filePath, $attachment->getFilePath());

        $attachment->setUpdated();
        $attachment->setNotVisible();
        $attachment->setLocked();

        $this->assertEntityValid($attachment);
        $this->assertTrue($attachment->getUpdated()->getTimestamp() > 0);
        $this->assertFalse($attachment->isVisible());
        $this->assertTrue($attachment->isLocked());
    }
}
