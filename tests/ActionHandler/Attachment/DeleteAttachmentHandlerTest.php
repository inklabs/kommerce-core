<?php
namespace inklabs\kommerce\ActionHandler\Attachment;

use inklabs\kommerce\Action\Attachment\DeleteAttachmentCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteAttachmentHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $attachmentService = $this->mockService->getAttachmentService();
        $attachmentService->shouldReceive('delete')
            ->once();

        $command = new DeleteAttachmentCommand(self::UUID_HEX);
        $handler = new DeleteAttachmentHandler($attachmentService);
        $handler->handle($command);
    }
}
