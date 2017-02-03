<?php
namespace inklabs\kommerce\ActionHandler\Attachment;

use inklabs\kommerce\Action\Attachment\MarkAttachmentUnlockedCommand;
use inklabs\kommerce\Entity\Attachment;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class MarkAttachmentUnlockedHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Attachment::class,
        OrderItem::class,
    ];

    public function testHandle()
    {
        $attachment = $this->dummyData->getAttachment();
        $attachment->setLocked();
        $this->persistEntityAndFlushClear($attachment);
        $command = new MarkAttachmentUnlockedCommand($attachment->getId()->getHex());

        $this->dispatchCommand($command);

        $attachment = $this->getRepositoryFactory()->getAttachmentRepository()->findOneById(
            $attachment->getId()
        );
        $this->assertFalse($attachment->isLocked());
    }
}
