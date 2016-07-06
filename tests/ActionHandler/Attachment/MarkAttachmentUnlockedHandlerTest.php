<?php
namespace inklabs\kommerce\ActionHandler\Attachment;

use inklabs\kommerce\Action\Attachment\MarkAttachmentUnlockedCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class MarkAttachmentUnlockedHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $attachment = $this->dummyData->getAttachment();
        $attachment->setLocked();

        $attachmentService = $this->mockService->getAttachmentService();
        $this->serviceShouldGetOneById($attachmentService, $attachment);
        $this->serviceShouldUpdate($attachmentService, $attachment);

        $command = new MarkAttachmentUnlockedCommand($attachment->getId()->getHex());
        $handler = new MarkAttachmentUnlockedHandler($attachmentService);
        $handler->handle($command);

        $this->assertFalse($attachment->isLocked());
    }
}
