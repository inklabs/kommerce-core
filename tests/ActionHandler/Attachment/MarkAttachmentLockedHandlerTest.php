<?php
namespace inklabs\kommerce\ActionHandler\Attachment;

use inklabs\kommerce\Action\Attachment\MarkAttachmentLockedCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class MarkAttachmentLockedHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $attachment = $this->dummyData->getAttachment();
        $attachment->setUnlocked();

        $attachmentService = $this->mockService->getAttachmentService();
        $this->serviceShouldGetOneById($attachmentService, $attachment);
        $this->serviceShouldUpdate($attachmentService, $attachment);

        $command = new MarkAttachmentLockedCommand($attachment->getId()->getHex());
        $handler = new MarkAttachmentLockedHandler($attachmentService);
        $handler->handle($command);

        $this->assertTrue($attachment->isLocked());
    }
}
