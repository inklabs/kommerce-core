<?php
namespace inklabs\kommerce\ActionHandler\Attachment;

use inklabs\kommerce\Action\Attachment\MarkAttachmentLockedCommand;
use inklabs\kommerce\Entity\Attachment;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class MarkAttachmentLockedHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Attachment::class,
        OrderItem::class,
    ];

    public function testHandle()
    {
        $attachment = $this->dummyData->getAttachment();
        $attachment->setUnlocked();
        $this->persistEntityAndFlushClear($attachment);
        $command = new MarkAttachmentLockedCommand($attachment->getId()->getHex());

        $this->dispatchCommand($command);

        $attachment = $this->getRepositoryFactory()->getAttachmentRepository()->findOneById(
            $attachment->getId()
        );
        $this->assertTrue($attachment->isLocked());
    }
}
