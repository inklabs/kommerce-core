<?php
namespace inklabs\kommerce\ActionHandler\Attachment;

use inklabs\kommerce\Action\Attachment\DeleteAttachmentCommand;
use inklabs\kommerce\Entity\Attachment;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteAttachmentHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Attachment::class,
        OrderItem::class,
    ];

    public function testHandle()
    {
        $attachment = $this->dummyData->getAttachment();
        $this->persistEntityAndFlushClear($attachment);
        $command = new DeleteAttachmentCommand($attachment->getId()->getHex());

        $this->dispatchCommand($command);

        $this->expectException(EntityNotFoundException::class);
        $this->getRepositoryFactory()->getAttachmentRepository()->findOneById(
            $attachment->getId()
        );
    }
}
