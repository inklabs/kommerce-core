<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class AttachmentTest extends EntityTestCase
{
    public function testCreate()
    {
        $filePath = 'img/example.png';
        $attachment = new Attachment($filePath);

        $this->assertTrue($attachment instanceof EntityInterface);
        $this->assertEntityValid($attachment);
        $this->assertTrue($attachment->getCreated()->getTimestamp() > 0);
        $this->assertSame(null, $attachment->getId());
        $this->assertSame(null, $attachment->getUpdated());
        $this->assertSame($filePath, $attachment->getFilePath());

        $attachment->setUpdated();

        $this->assertEntityValid($attachment);
        $this->assertTrue($attachment->getUpdated()->getTimestamp() > 0);
    }
}
