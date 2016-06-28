<?php
namespace inklabs\kommerce\ActionHandler\Attachment;

use inklabs\kommerce\Action\Attachment\DeleteAttachmentCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteAttachmentHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $attachment = $this->dummyData->getAttachment();

        $attachmentService = $this->mockService->getAttachmentService();
        $attachmentService->shouldReceive('delete')
            ->with($attachment->getId())
            ->once();

        $command = new DeleteAttachmentCommand($attachment->getId()->getHex());
        $handler = new DeleteAttachmentHandler($attachmentService);
        $handler->handle($command);
    }
}
