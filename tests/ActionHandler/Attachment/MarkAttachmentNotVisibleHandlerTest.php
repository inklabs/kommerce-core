<?php
namespace inklabs\kommerce\ActionHandler\Attachment;

use inklabs\kommerce\Action\Attachment\MarkAttachmentNotVisibleCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class MarkAttachmentNotVisibleHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $attachment = $this->dummyData->getAttachment();
        $attachment->setVisible();

        $attachmentService = $this->mockService->getAttachmentService();
        $this->serviceShouldGetOneById($attachmentService, $attachment);
        $this->serviceShouldUpdate($attachmentService, $attachment);

        $command = new MarkAttachmentNotVisibleCommand($attachment->getId()->getHex());
        $handler = new MarkAttachmentNotVisibleHandler($attachmentService);
        $handler->handle($command);

        $this->assertFalse($attachment->isVisible());
    }
}
