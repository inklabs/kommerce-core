<?php
namespace inklabs\kommerce\ActionHandler\Attachment;

use inklabs\kommerce\Action\Attachment\MarkAttachmentVisibleCommand;
use inklabs\kommerce\Entity\Attachment;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class MarkAttachmentVisibleHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Attachment::class,
        OrderItem::class,
    ];

    public function testHandle()
    {
        $attachment = $this->dummyData->getAttachment();
        $attachment->setNotVisible();
        $this->persistEntityAndFlushClear($attachment);
        $command = new MarkAttachmentVisibleCommand($attachment->getId()->getHex());

        $this->dispatchCommand($command);

        $attachment = $this->getRepositoryFactory()->getAttachmentRepository()->findOneById(
            $attachment->getId()
        );
        $this->assertTrue($attachment->isVisible());
    }
}
